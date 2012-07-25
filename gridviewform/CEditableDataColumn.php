<?php

/**
 * CEditableColumn class file.
 *
 * @author Herbert Maschke <thyseus@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2010 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
Yii::import('zii.widgets.grid.CGridColumn');

/**
 * CEditableColumn represents a grid view column that is editable.
 *
 * @author Herbert Maschke <thyseus@gmail.com>
 * @package zii.widgets.grid
 * @since 1.1
 */
class CEditableDataColumn extends CDataColumn {

    /**
     * Renders the data cell content.
     * @param integer the row number (zero-based)
     * @param mixed the data associated with the row
     */
    protected function renderDataCellContent($row, $data) {
        if ($this->value !== null)
            $value = $this->evaluateExpression($this->value, array('data' => $data, 'row' => $row));
        else if ($this->name !== null)
            $value = CHtml::value($data, $this->name);
        //echo $value === null ? $this->grid->nullDisplay : $this->grid->getFormatter()->format($value, $this->type);
//        echo "row:";
//        print_r($row);
//        echo "<br>data:";
//        print_r($data);
        
        printf('<input style="width:98%%" name="%sUpdate[%s][%s]" type="text" value="%s" />', 
                get_class($data), $data->id,$this->name, $value);
    }

}
