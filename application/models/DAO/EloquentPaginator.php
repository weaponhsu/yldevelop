<?php


namespace models\DAO;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use models\Exception\DAO\ModelException;

class EloquentPaginator
{
    static private $instance = null;

    protected $sort = '';
    protected $order = '';

    protected $data = null;
    protected $meta = null;

    private $builder = null;
    private $total = 0;
    private $page = 1;
    private $page_size = 10;

    /**
     * @param $builder
     * @param $page
     * @param int $page_size
     * @return null
     * @throws ModelException
     */
    static public function getInstance($builder, $page, $page_size = 10) {
        if (is_null(static::$instance))
            self::$instance = new static($builder, $page, $page_size);

        return self::$instance;
    }

    /**
     * EloquentPaginator constructor.
     * @param $builder
     * @param $page
     * @param int $page_size
     * @throws ModelException
     */
    private function __construct($builder, $page, $page_size = 10)
    {
        if (! $builder instanceof Builder && ! $builder instanceof Model)
            throw new ModelException(ModelException::INVALID_BUILDER_CLASS, ModelException::INVALID_BUILDER_CLASS_NO);
        else
            $this->builder = $builder->getQuery();

        if (! $this->builder instanceof QueryBuilder)
            throw new ModelException(ModelException::INVALID_BUILDER, ModelException::INVALID_BUILDER_NO);

        $this->page = $page;
        $this->page_size = $page_size;
    }

    /**
     * @param $sort
     * @return $this
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @param $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return null
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * 读取数据 生成翻页信息
     * @return $this
     * @throws ModelException
     */
    public function paginator() {

        if (!empty($this->order)) {
            $this->builder->orderBy($this->order, $this->sort);
        }

        $this->total = $this->builder->count();

        // 查无数据
        if ($this->total == 0)
            throw new ModelException(ModelException::DATA_NOT_EXISTS, ModelException::DATA_NOT_EXISTS_NO);

        $this->setData();

        if ($this->total > 0)
            $this->setMeta();

        return $this;
    }

    /**
     * 将查询结果集设置给data属性
     */
    private function setData() {
        $start_pos = ($this->page - 1) * $this->page_size;

        $this->data = $this->builder->skip($start_pos)->take($this->page_size)->get()->toArray();
    }

    /**
     * 将翻页信息设置给meta
     * @throws ModelException
     */
    private function setMeta() {
        try {
            if (! property_exists($this, 'meta'))
                throw new ModelException(ModelException::THERE_IS_NOT_META_VAR, ModelException::THERE_IS_NOT_META_VAR_NO);

            $this->meta = new \stdClass();

            $this->meta->total = intval($this->total);

            $this->meta->links = new \stdClass();
            $this->meta->total_pages = 0;
            $this->meta->per_page = $this->perPage;
            $this->meta->current_page = $this->page;
            $this->meta->count = 0;

            if (! property_exists($this, 'page'))
                throw new ModelException(ModelException::THERE_IS_NO_PAGE_VAR, 400);
            if (! property_exists($this, 'page_size'))
                throw new ModelException(ModelException::THERE_IS_NO_PAGE_SIZE_VAR, 400);

            if($this->page !== 0 && $this->page_size !== 0){
                $this->meta->per_page = intval($this->perPage);
                $this->meta->total_pages = intval(ceil($this->total/$this->page_size));
                $this->meta->current_page = $this->page;
                $this->meta->count = $this->meta->total_pages <= 1 ? $this->meta->total :
                    ($this->meta->total_pages != $this->meta->current_page ?
                        $this->meta->per_page :
                        $this->meta->total - (($this->meta->current_page - 1) * $this->meta->per_page));
            }

            if($this->meta->total_pages !== 0)
                if($this->meta->total_pages > $this->meta->current_page + 1)
                    $this->meta->links->next_page = $this->meta->current_page + 1;
            if($this->meta->current_page > 1 && $this->meta->total_pages > 1)
                $this->meta->links->last_page = $this->meta->current_page - 1;

        } catch (ModelException $e) {
            throw $e;
        }
    }

}
