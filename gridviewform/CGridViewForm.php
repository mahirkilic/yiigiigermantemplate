<?php

/**
 * CGridViewForm class file.
 *
 * @author Mahir Kilic (kilic_mahir@hotmail.com)
 * @copyright Copyright &copy; 2012 Cosco
 *
 */
Yii::import("zii.widgets.grid.CGridView");

class CGridViewForm extends CGridView {
    
    /**
     * Initialize the widget
     */
    public function init() {
        parent::init();
        $this->selectableRows = 2;
        $this->template = "{items}\n{summary}{pager}";
        $this->summaryCssClass = "summary left";
    }

    /**
     * Run the widget
     */
    public function run() {
        $actions = array(' ' => ' ', 'create' => Yii::t('application', 'Erstellen'), 'delete' => Yii::t('application', 'Löschen'),);
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'admin-form',
            'enableAjaxValidation' => false,
                ));
        echo "<span class='right bottom ' >
            <span style='margin-right: 15px;'>per Page ";
        $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
        echo CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('".$this->id."',{ data:{pageSize: $(this).val() }})",
                    )); 
        echo "</span>
                <span>Action</span> ";
        echo CHtml::dropDownList('action', '', $actions);
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name' => 'actionExecute',
            'buttonType' => 'button',
            'caption' => 'Go',
            'onclick' => 'js:function(){
                                if($("#action").val() == "delete"){
                                    check = confirm("'.Yii::t('application', 'Wollen Sie wirklich alle ausgewählte Einträge löschen?').'");
                                    if (check == false){
                                        return;
                                    }
                                }
                                $("#admin-form").submit();
                            }',
            'htmlOptions' => array(
                'style' => 'font-size:0.7em;'
            ),
        ));
        echo "</span>";
        parent::run();
        $this->endWidget();
    }

}