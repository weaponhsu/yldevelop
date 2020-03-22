<?php

namespace Common;

use Yaf\Exception;
use models\DAO\SiteModel;
use models\Service\CityService;
use models\Transformer\CityTransformer;
use models\Service\AreaService;
use models\Transformer\AreaTransformer;
use PHPExcel_IOFactory;

class PhpExcelImport
{

    static public $instance = null;
    public $table_name = '';
    public $file_name = '';
    public $allowed_table = ['products'];
    public $column_arr = [
        'products' => ['title', 'num', 'auction', 'deadline', 'bid', 'desc', 'category_id', 'area_code']
    ];

    static public function getInstance($table_name = 'products') {
        if (is_null(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    public function __construct($table_name = 'products')
    {
        if (! in_array($table_name, $this->allowed_table))
            throw new Exception('非法导入表');

        $this->table_name = $table_name;
    }

    /**
     * 设置导入文件
     * @param string $file_name
     * @return $this
     * @throws Exception
     */
    public function setFileName($file_name = '') {
        if (file_exists($file_name) === false)
            throw new Exception('xlsx文件不存在');
        $this->file_name = $file_name;
        return $this;
    }

    /**
     * 根据excel导入数据
     * @return bool
     * @throws Exception
     */
    public function import() {
        try {
            $obj_excel = PHPExcel_IOFactory::load($this->file_name);
            $currentSheet = $obj_excel->getSheet(0);
            $row_num = $currentSheet->getHighestRow();
            $col_max = $currentSheet->getHighestColumn();

            $value_arr = $city_name_arr = $area_name_arr = $field_value_arr = $field_time_value_arr = [];
            for($i = 2; $i <= $row_num; $i++)  {
                $cell_values = array();
                for($j = 'A'; $j <= $col_max; $j++)
                {
                    $address = $j . $i; // 单元格坐标
                    $value = $currentSheet->getCell($address)->getFormattedValue();
                    $cell_values[] = $value;

                    if ($j == 'H')
                        array_push($city_name_arr, strrpos($value, '市') === false ? $value . '市' : $value);
                    if ($j == 'I')
                        array_push($area_name_arr, strrpos($value, '区') === false ? $value . '区' : $value);
                }

                if ($cell_values[8] == '暂无')
                    $cell_values[8] = '0';

                $deadline = date('Y-m-d H:i:s', strtotime($cell_values[3]));
                $cell_values[3] = $deadline;

                array_push($value_arr, $cell_values);
            }

            $city_data = static::getCityCodeByCityName(implode('', array_filter(array_unique($city_name_arr))));
            if (empty($city_data))
                throw new Exception('城市数据获取失败，请查看城市名称是否有误');

            // 获取区县数据 area_name_code_arr = ['area_code_1' => 'area_name_1', 'area_code_2' => 'area_name_2', ... ]
            $area_name_code_arr = static::getAreaCodeByCityCode($city_data['code']);
            if (empty($area_name_code_arr))
                throw new Exception('区县数据获取失败，请查看城市名称是否有误');
            
            foreach ($value_arr as $num => $record) {
                if (false !== $area_code = array_search($record[8], $area_name_code_arr)) {
                    unset($value_arr[$num][7]);
                    unset($value_arr[$num][8]);
                    array_push($value_arr[$num], (string)$area_code);
                }
            }

            $batch_insert_site_sql = '';
            if (!empty($value_arr)) {

                $batch_insert_site_sql = "INSERT INTO `" . $this->table_name . "` (`" . implode('`, `', $this->column_arr[$this->table_name]) . "`) VALUES ";

                foreach ($value_arr as $record)
                    $batch_insert_site_sql .= "('" . implode("', '", $record) . "'),";

                $batch_insert_site_sql = substr($batch_insert_site_sql, 0, strrpos($batch_insert_site_sql, ',')) . ';';
            }

            if (!empty($batch_insert_site_sql))
                SiteModel::getInstance()->query($batch_insert_site_sql);

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * 根据城市名称获取城市code
     * @param $city_name
     * @return array|CityTransformer|string
     */
    static private function getCityCodeByCityName($city_name = '') {
        $area_name_code_arr = [];
        if (empty($city_name))
            return $area_name_code_arr;

        $city = CityService::getInstance()->getOne(
            ['groupOp' => 'AND', 'rules' => [['field' => 'name', 'op' => 'eq', 'data' => $city_name]]]
            ,1 ,1 , 'id', 'desc');
        return $city;
    }

    /**
     * 根据城市编号获取该城市的所有区县code和name数组
     * @param string $city_code
     * @return array
     */
    static private function getAreaCodeByCityCode($city_code = '') {
        $area_name_code_arr = [];
        if (empty($city_code))
            return $area_name_code_arr;

        $area = AreaService::getInstance()->getList(1, 999, 'desc', 'id',
            ['groupOp' => 'AND', 'rules' => [['field' => 'parent_id', 'op' => 'eq', 'data' => $city_code]]]);

        $area_name_code_arr = array_column($area['data'], 'name', 'code');
        return $area_name_code_arr;
    }

    /**
     * 接受岂止时间，并按照步长拆分成数组
     * 例: 09:00-22:00并按照30分钟拆分数组
     * 结果为: [21:30-22:00, 21:00-21:30, ..., 09:30-10:00, 09:00-09:30]
     * @param $end_time 开始时间 也就是闭馆时间
     * @param $start_time 截止时间 也就是开馆时间
     * @param int $step 步长 单位分钟
     * @param array $arr 返回数组
     * @return array
     */
    static private function getTime($end_time, $start_time, $step = 1, $arr = []) {
        if ($end_time <= $start_time)
            return $arr;
        else {
            array_push($arr, date('H:i', $end_time - ($step * 60)) . '-' . date('H:i', $end_time));
            return static::getTime($end_time - ($step * 60), $start_time, $step, $arr);
        }
    }

}