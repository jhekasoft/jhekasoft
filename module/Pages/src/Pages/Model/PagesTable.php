<?php

namespace Pages\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Paginator\Adapter\Iterator;
use Zend\Paginator\Paginator;
use Zend\ServiceManager\ServiceManager;

class PagesTable extends AbstractTableGateway
{

    protected $table = 'jh_page';
    protected $serviceManager;

    public function __construct(Adapter $adapter, ServiceManager $serviceManager)
    {
        $this->adapter = $adapter;
        $this->serviceManager = $serviceManager;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(
            $this->serviceManager->get('Pages\Model\Pages')
        );
        //$this->resultSetPrototype->setArrayObjectPrototype(new Pages());

        $this->initialize();
    }

    public function fetchAll($options = array())
    {
        $where = array();

        // Условие отображаемых строк
        // Варианты: yes, no, all. По умолчанию yes
        // Если all, то не добавляем условие
        $show = 'yes';
        if (!empty($options['show'])) {
            $show = $options['show'];
        }
        if ($show != 'all') {
            $where[] = "`show` = '{$show}'";
        }

        // Родительская страница
        $par_id = 'all';
        if (!empty($options['parent'])) {
            $parentItem = $this->getItem($options['parent'], array(
                'field' => 'name',
            ));

            if ($parentItem) {
                $par_id = $parentItem->id;
            }
        }
        if ($par_id != 'all') {
            $where[] = "`par_id` = '{$par_id}'";
        }

        $resultSet = $this->select($where);
        $resultSet->buffer();
        $resultSet->current();

        return $resultSet;
    }

    public function getPaginator($options = array())
    {
        $page = 1;

        if (!empty($options['page'])) {
            $page = (int) $options['page'];
        }

        $iteratorAdapter = new Iterator($this->fetchAll($options));
        $paginator = new Paginator($iteratorAdapter);

        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);

        return $paginator;
    }

    public function getItem($id, $options = array())
    {
        $fieldName = 'id';

        if (!empty($options['field'])) {
            $fieldName = $options['field'];
        }

        $rowset = $this->select(array(
            $fieldName => $id,
        ));

        $row = $rowset->current();

        return $row;
    }

    public function saveItem(Pages $item)
    {
        $data = array(
            'name' => $item->name,
            'datetime' => $item->datetime,
            'title' => $item->title,
            'text' => $item->text,
            'meta_keywords' => $item->meta_keywords,
            'show_share' => $item->show_share,
            'show_comments' => $item->show_comments,
        );

        if (!empty($item->show)) {
            $data['show'] = $item->show;
        }

        $id = (int) $item->id;

        if ($id == 0) {
            $this->insert($data);
        } elseif ($this->getItem($id)) {
            $this->update(
                $data, array(
                'id' => $id,
                )
            );
        } else {
            throw new \Exception('Form id does not exist');
        }
    }

//    public function deleteItem($id)
//    {
//        $this->delete(array(
//            'id' => $id,
//        ));
//    }
}
