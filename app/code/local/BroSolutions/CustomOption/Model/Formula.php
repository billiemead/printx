<?php

class BroSolutions_CustomOption_Model_Formula extends Varien_Object
{
    const FORMULA_TYPE_PER_QUANTITY = 1;
    const FORMULA_TYPE_PER_PAGES = 2;
    const FORMULA_TYPE_PER_VERSIONS = 3;
    const FORMULA_TYPE_QUANTITY_BY_TASK = 4;
    const FORMULA_TYPE_TASK_QUANTITY_JOB_QUANTITY = 5;
    const FORMULA_TYPE_PERIMETER_OF_JOB = 6;
    const FORMULA_TYPE_LINEAR_FEETOF_JOB_WIDTH = 7;
    const FORMULA_TYPE_LINEAR_FEETOF_JOB_HEIGHT = 8;
    const FORMULA_TYPE_SQUARE_FEET_OF_ART = 9;
    const FORMULA_TYPE_PERIMETER_OF_JOB__FREQUENCY = 10;
    const FORMULA_TYPE_QUANTITY_SPEED = 11;
    const FORMULA_TYPE_TASK_QTY_SPEED = 12;
    const FORMULA_TYPE_HOURLY = 13;
    const FORMULA_TYPE_HOURLY_PER_VERSION = 14;
    
    
    protected $_formulas = array(
        self::FORMULA_TYPE_PER_QUANTITY => 'Per Quantity',
        self::FORMULA_TYPE_PER_PAGES => 'Per Pages',
        self::FORMULA_TYPE_PER_VERSIONS => 'Per Versions',
        self::FORMULA_TYPE_QUANTITY_BY_TASK => 'Quantity By Task',
        self::FORMULA_TYPE_TASK_QUANTITY_JOB_QUANTITY => 'Quantity * Task Quantity',
        self::FORMULA_TYPE_PERIMETER_OF_JOB => 'Perimeter of Job',
        self::FORMULA_TYPE_LINEAR_FEETOF_JOB_WIDTH => 'Linear Feet of Job (Width)',
        self::FORMULA_TYPE_LINEAR_FEETOF_JOB_HEIGHT => 'Linear Feet of Job (Height)',
        self::FORMULA_TYPE_SQUARE_FEET_OF_ART => 'Square Feet of Art',
        self::FORMULA_TYPE_PERIMETER_OF_JOB__FREQUENCY => 'Perimeter of Job x Freq.',
        self::FORMULA_TYPE_QUANTITY_SPEED => 'Quantity / Speed',
        self::FORMULA_TYPE_TASK_QTY_SPEED => 'Task Qty / Speed',
        self::FORMULA_TYPE_HOURLY => 'Hourly',
        self::FORMULA_TYPE_HOURLY_PER_VERSION => 'Hourly per Version',
    );
    
    public function getFormulasList()
    {
        return $this->_formulas;
    }
    
    public function toOptionArray()
    {
        $res = array();
        foreach($this->_formulas as $type => $name){
            $res[] = array(
                'value'=>$type,
                'label'=>$name,
            );
        }
            
        return $res;
    }
    
    
    public function getHelperText()
    {
        return array(
            self::FORMULA_TYPE_PER_QUANTITY => array('title'=>'Per Quantity',
                                                    'subtitle'=>'Total Quantity in Job',
                                                    'text'=>'This formula considers the total number of pieces produced for a job and then applies the price to this value. It would be used
                                                                when you want to charge a price for every piece.
                                                                For example a Quantity of 500 (value is pulled from the option Quantity Breaks) * 2 Versions (remember, versions is now the
                                                                Magento default Quantity field) = 1000 total pieces. The Option pricing is then obtained with the following calculation: ((1000
                                                                pieces * variable price) + fixed price) * TaskQty) + setup.',
                                                    'formula'=>'(((($quantity * $versions = $processQuantity) * $price) + fixedPrice) * taskQty) + $setup'),
            
            self::FORMULA_TYPE_PER_PAGES => array('title'=>'Per Pages',
                                                    'subtitle'=>'Number of Pages in Job',
                                                    'text'=>'This formula is based on Number of Pages options value. This can produce a variable charge that grows with thickness of a
                                                            book, etc.',
                                                    'formula'=>'((((pages * versions) * price) + fixedPrice) * taskQty) + setup'),
            
            self::FORMULA_TYPE_PER_VERSIONS => array('title'=>'Per Versions',
                                                    'subtitle'=>'Number of Versions in Job',
                                                    'text'=>'This process will calculate charges based on the number of versions and multiple it by price per each',
                                                    'formula'=>'((((versions) * price) + fixedPrice) * taskQty) + setup'),
                
            self::FORMULA_TYPE_QUANTITY_BY_TASK => array('title'=>'Quantity By Task',
                                                    'subtitle'=>'Number of Pieces / Task Quantity',
                                                    'text'=>'This calculation will take the total number of pieces and divide it by the "task quantity". For example this formula can be used to
                                                        determine the quantity of shrink wrapped sets in a job that uses a task quantity of 25 sheets per set. Total number of pieces
                                                        equals 1000 / 25 = 40 shrink wrapped sets which will then be multiplied by the price per set.',
                                                    'formula'=>'(((quantity * versions) / taskqty) * price) + fixedPrice + $setup'),
                
            self::FORMULA_TYPE_TASK_QUANTITY_JOB_QUANTITY => array('title'=>'Quantity * Task Quantity',
                                                    'subtitle'=>'Task Quantity * Job Quantity',
                                                    'text'=>'Useful for a process you perform x times per unit produced',
                                                    'formula'=>'(((quantity * versions) * taskqty) * price) + fixedPrice + setup'),
                
            self::FORMULA_TYPE_PERIMETER_OF_JOB => array('title'=>'Perimeter of Job',
                                                    'subtitle'=>'Perimeter * Quantit',
                                                    'text'=>'This counts the measurement around the edge of a project. Useful for calculating charges like taping the edge of posters.
                                                            FinishW and FinishH are taken from Size Custom Option.',
                                                    'formula'=>'(((((((finishW + finishH) * 2) * quantity ) * versions) * price) + fixedPrice) * taskqty) + setup'),
                
            self::FORMULA_TYPE_LINEAR_FEETOF_JOB_WIDTH => array('title'=>'Linear Feet of Job (Width)',
                                                    'subtitle'=>'Job Width in Feet * Quantity',
                                                    'text'=>'This process will calculate the total job width in feet and multiple by the quantity. Example. 10 quantity of a 120in x 60in banner
                                                            would calculate as such. (120in + 2in gap ) / 12in * 10qty = 101.66 feet',
                                                    'formula'=>'(((((((runW + gap) / 12) * quantity) * versions) * price) + fixedPrice) * taskqty) + setup'),
                
            self::FORMULA_TYPE_LINEAR_FEETOF_JOB_HEIGHT => array('title'=>'Linear Feet of Job (Height)',
                                                    'subtitle'=>'Job Height in Feet * Quantity',
                                                    'text'=>'This process will calculate the total job height in feet and multiple by the quantity. Example. 10 quantity of a 120in x 60in banner
                                                            would calculate as such. (60in + 2in gap) / 12in * 10qty = 51.666 feet',
                                                    'formula'=>'(((((((runH + gap) / 12) * quantity) * versions) * price) + fixedPrice) * taskqty) + setup'),
                
            self::FORMULA_TYPE_SQUARE_FEET_OF_ART => array('title'=>'Square Feet of Art',
                                                    'subtitle'=>'Square ft. / Price',
                                                    'text'=>'This process will calculate charges based on the square feet of print area. Useful for process like mounting poster material.',
                                                    'formula'=>'((((((finishW * finishH) * quantity) * versions) * price) + fixedPrice) * taskqty) + setup'),
                
            self::FORMULA_TYPE_PERIMETER_OF_JOB__FREQUENCY => array('title'=>'Perimeter of Job x Freq.',
                                                    'subtitle'=>'Perimeter / Gap',
                                                    'text'=>'This counts the measurement around the edge of a project and then uses the value in Gap to determine how often a fee should
                                                            be charged. Useful for calculating charges like grommets for banner every 5 inches. FinishW and FinishH are taken from Size
                                                            Custom Option.',
                                                    'formula'=>'((((((((finishW + finishH) * 2) / gap) * quantity ) * versions) * price) + fixedPrice) * taskqty) + setup'),
                
            self::FORMULA_TYPE_QUANTITY_SPEED => array('title'=>'Quantity / Speed',
                                                    'subtitle'=>'TaskQty / Speed * Rate',
                                                    'text'=>'This formula is for Finishing Tasks that is calculated based on the ordered Quantity and how many can be competed in a given
                                                            time, at a fixed hourly rate. If a value is entered for set-up time, then we need to calculate that time as not being productive and
                                                            this need to be calculated first.',
                                                    'formula'=>'((((((speed / 60) * setuptime) + qty) / speed) * rate) * versions) + setup'),
                
            self::FORMULA_TYPE_TASK_QTY_SPEED => array('title'=>'TaskQty / Speed',
                                                    'subtitle'=>'TaskQty / Speed * Rate',
                                                    'text'=>'This formula is for Finishing Tasks that is instead calculated based on the TaskQty and how many can be competed in a given
                                                            time at a fixed hourly rate. No fields are used from any other option in the calculation. If a value is entered for set-up time, then
                                                            we need to calculate that time as not being productive and this need to be calculated first.',
                                                    'formula'=>'((((((speed / 60) * setuptime) + taskqty) / speed) * rate) * versions) + setup'),
                
            self::FORMULA_TYPE_HOURLY => array('title'=>'Hourly',
                                                    'subtitle'=>'TaskQty / Rate',
                                                    'text'=>'This formula is for Finishing Tasks that are charged hourly. No fields are used from any other option in the calculation',
                                                    'formula'=>'((taskqty) * rate) + setup'),
                
            self::FORMULA_TYPE_HOURLY_PER_VERSION => array('title'=>'Hourly per Version',
                                                    'subtitle'=>'TaskQty / Rate',
                                                    'text'=>'This formula is for Finishing Tasks that are charged hourly. No fields are used from any other option in the calculation',
                                                    'formula'=>'(((taskqty) * rate) * versions) + setup'),
                
        );
    }
    
    /**
     * 
     * @param type $formulaId
     */
    public function calculate($formulaId, $object){
        switch($formulaId){
            case self::FORMULA_TYPE_PER_QUANTITY:
                $value = (((($object->getQty()* $object->getVersions())*$object->getPrice())+$object->getFixedprice())*$object->getTaskqty())+$object->getSetup();
                break;
            
            case self::FORMULA_TYPE_PER_PAGES:
                $value = (((($object->getPages()*$object->getVersions())*$object->getPrice())+$object->getFixedprice())*$object->getTaskqty())+$object->getSetup();
                break;
            
            case self::FORMULA_TYPE_PER_VERSIONS:
                $value = ((($object->getVersions()*$object->getPrice())+$object->getFixedprice())*$object->getTaskqty()) + $object->getSetup();
                break;
            
            case self::FORMULA_TYPE_QUANTITY_BY_TASK:
                $value = ((($object->getQty()* $object->getVersions())/$object->getTaskqty())*$object->getPrice())+$object->getFixedprice()+$object->getSetup();
                break;
            
            case self::FORMULA_TYPE_TASK_QUANTITY_JOB_QUANTITY:
                $value = ((($object->getQty()* $object->getVersions())*$object->getTaskqty())*$object->getPrice())+$object->getFixedprice()+$object->getSetup();
                break;
            
            case self::FORMULA_TYPE_PERIMETER_OF_JOB:
                $value = (((($object->getFinishW() + $object->getFinishH())*2*$object->getQty()*$object->getVersions()*$object->getPrice())+$object->getFixedprice())*$object->getTaskqty())+$object->getSetup();
                break;
            
            case self::FORMULA_TYPE_LINEAR_FEETOF_JOB_WIDTH:
                $value = ((((($object->getRunW()+$object->getGap())/12)*$object->getQty()* $object->getVersions()*$object->getPrice())+$object->getFixedprice())*$object->getTaskqty())+$object->getSetup();
                break;
            
            case self::FORMULA_TYPE_LINEAR_FEETOF_JOB_HEIGHT:
                $value = ((((($object->getRunH()+$object->getGap())/12)*$object->getQty()* $object->getVersions()*$object->getPrice())+$object->getFixedprice())*$object->getTaskqty())+$object->getSetup();
                break;
            
            case self::FORMULA_TYPE_SQUARE_FEET_OF_ART:
                $value = (((($object->getFinishW() * $object->getFinishH())*$object->getQty()*$object->getVersions()*$object->getPrice())+$object->getFixedprice())*$object->getTaskqty())+$object->getSetup();
                break;
            
            case self::FORMULA_TYPE_PERIMETER_OF_JOB__FREQUENCY:
                $value = (((((($object->getFinishW() + $object->getFinishH())*2)/$object->getGap())*$object->getQty()*$object->getVersions()*$object->getPrice())+$object->getFixedprice())*$object->getTaskqty())+$object->getSetup();
                break;
            
            case self::FORMULA_TYPE_QUANTITY_SPEED:
                $value = ((((($object->getSpeed()/60)*$object->getSetuptime())+$object->getQty())/$object->getSpeed())*$object->getRate()*$object->getVersions())+$object->getSetup();
                break;
            
            case self::FORMULA_TYPE_TASK_QTY_SPEED:
                $value = ((((($object->getSpeed()/60)*$object->getSetuptime())+$object->getTaskqty())/$object->getSpeed())*$object->getRate()*$object->getVersions())+$object->getSetup();
                break;
            
            case self::FORMULA_TYPE_HOURLY:
                $value = ($object->getTaskQty()*$object->getRate())+$object->getSetup();
                break;
            
            case self::FORMULA_TYPE_HOURLY_PER_VERSION:
                $value = ($object->getTaskQty()*$object->getRate()*$object->getVersions())+$object->getSetup();
                break;
        }
        
        return max($value,$object->getMin());
    }
    
    
    /**
     * 
     * @param type $formulaId
     */
    public function getJSFormula($formulaId){
        $value = 0;
        switch($formulaId){
            case self::FORMULA_TYPE_PER_QUANTITY:
                $value = '(qty>0)?(((((qty* versions)*price)+fixedprice)*taskqty)+setup):0';
                break;
            
            case self::FORMULA_TYPE_PER_PAGES:
                $value = '(pages>0)?(((((pages*versions)*price)+fixedprice)*taskqty)+setup):0';
                break;
            
            case self::FORMULA_TYPE_PER_VERSIONS:
                $value = '(versions>0)?((((versions*price)+fixedprice)*taskqty) + setup):0';
                break;
            
            case self::FORMULA_TYPE_QUANTITY_BY_TASK:
                $value = '(qty>0)?((((qty* versions)/taskqty)*price)+fixedprice+setup):0';
                break;
            
            case self::FORMULA_TYPE_TASK_QUANTITY_JOB_QUANTITY:
                $value = '(qty>0)?((((qty* versions)*taskqty)*price)+fixedprice+setup):0';
                break;
            
            case self::FORMULA_TYPE_PERIMETER_OF_JOB:
                $value = '(qty>0)?(((((finishw + finishh)*2*qty*versions*price)+fixedprice)*taskqty)+setup):0';
                break;
            
            case self::FORMULA_TYPE_LINEAR_FEETOF_JOB_WIDTH:
                $value = '(qty>0)?((((((RunW+gap)/12)*qty* versions*price)+fixedprice)*taskqty)+setup):0';
                break;
            
            case self::FORMULA_TYPE_LINEAR_FEETOF_JOB_HEIGHT:
                $value = '(qty>0)?((((((runh+gap)/12)*qty* versions*price)+fixedprice)*taskqty)+setup):0';
                break;
            
            case self::FORMULA_TYPE_SQUARE_FEET_OF_ART:
                $value = '(qty>0)?(((((finishw * finishh)*qty*versions*price)+fixedprice)*taskqty)+setup):0';
                break;
            
            case self::FORMULA_TYPE_PERIMETER_OF_JOB__FREQUENCY:
                $value = '(qty>0)?(((((((finishw + finishh)*2)/gap)*qty*versions*price)+fixedprice)*taskqty)+setup):0';
                break;
            
            case self::FORMULA_TYPE_QUANTITY_SPEED:
                $value = '(qty>0)?((((((speed/60)*setuptime)+qty)/speed)*rate*versions)+setup):0';
                break;
            
            case self::FORMULA_TYPE_TASK_QTY_SPEED:
                $value = '(((((speed/60)*setuptime)+taskqty)/speed)*rate*versions)+setup';
                break;
            
            case self::FORMULA_TYPE_HOURLY:
                $value = '(taskqty*rate)+setup';
                break;
            
            case self::FORMULA_TYPE_HOURLY_PER_VERSION:
                $value = '(taskqty*rate*versions)+setup';
                break;
        }
        
        return $value;
    }
    
    public function getJSUsedFields($formulaId){
        $value = 0;
        switch($formulaId){
            case self::FORMULA_TYPE_PER_QUANTITY:
                //$value = '(qty>0)?(((((qty* versions)*price)+fixedprice)*taskqty)+setup):0';
                $value = "['product-option-taskqty','product-option-price','product-option-taskdesc','required-entry product-option-machineid']";
                break;
            
            case self::FORMULA_TYPE_PER_PAGES:
                //$value = '(pages>0)?(((((pages*versions)*price)+fixedprice)*taskqty)+setup):0';
                $value = "['product-option-taskqty','product-option-price','product-option-taskdesc','required-entry product-option-machineid']";
                break;
            
            case self::FORMULA_TYPE_PER_VERSIONS:
                //$value = '(versions>0)?((((versions*price)+fixedprice)*taskqty) + setup):0';
                $value = "['product-option-taskqty','product-option-price','product-option-taskdesc','required-entry product-option-machineid']";
                break;
            
            case self::FORMULA_TYPE_QUANTITY_BY_TASK:
                //$value = '(qty>0)?((((qty* versions)/taskqty)*price)+fixedprice+setup):0';
                $value = "['product-option-taskqty','product-option-price','product-option-taskdesc','required-entry product-option-machineid']";
                break;
            
            case self::FORMULA_TYPE_TASK_QUANTITY_JOB_QUANTITY:
                //$value = '(qty>0)?((((qty* versions)*taskqty)*price)+fixedprice+setup):0';
                $value = "['product-option-taskqty','product-option-price','product-option-taskdesc','required-entry product-option-machineid']";
                break;
            
            case self::FORMULA_TYPE_PERIMETER_OF_JOB:
                //$value = '(qty>0)?(((((finishw + finishh)*2*qty*versions*price)+fixedprice)*taskqty)+setup):0';
                $value = "['product-option-taskqty','product-option-price','product-option-taskdesc','required-entry product-option-machineid']";
                break;
            
            case self::FORMULA_TYPE_LINEAR_FEETOF_JOB_WIDTH:
                //$value = '(qty>0)?((((((RunW+gap)/12)*qty* versions*price)+fixedprice)*taskqty)+setup):0';
                $value = "['product-option-taskqty','product-option-gap','product-option-price','product-option-taskdesc','required-entry product-option-machineid']";
                break;
            
            case self::FORMULA_TYPE_LINEAR_FEETOF_JOB_HEIGHT:
                //$value = '(qty>0)?((((((runh+gap)/12)*qty* versions*price)+fixedprice)*taskqty)+setup):0';
                $value = "['product-option-taskqty','product-option-gap','product-option-price','product-option-taskdesc','required-entry product-option-machineid']";
                break;
            
            case self::FORMULA_TYPE_SQUARE_FEET_OF_ART:
                //$value = '(qty>0)?(((((finishw * finishh)*qty*versions*price)+fixedprice)*taskqty)+setup):0';
                $value = "['product-option-taskqty','product-option-price','product-option-taskdesc','required-entry product-option-machineid']";
                break;
            
            case self::FORMULA_TYPE_PERIMETER_OF_JOB__FREQUENCY:
                //$value = '(qty>0)?(((((((finishw + finishh)*2)/gap)*qty*versions*price)+fixedprice)*taskqty)+setup):0';
                $value = "['product-option-taskqty','product-option-gap','product-option-price','product-option-taskdesc','required-entry product-option-machineid']";
                break;
            
            case self::FORMULA_TYPE_QUANTITY_SPEED:
                //$value = '(qty>0)?((((((speed/60)*setuptime)+qty)/speed)*rate*versions)+setup):0';
                $value = "['product-option-taskqty','product-option-setuptime','product-option-taskdesc','required-entry product-option-machineid']";
                break;
            
            case self::FORMULA_TYPE_TASK_QTY_SPEED:
                //$value = '(((((speed/60)*setuptime)+taskqty)/speed)*rate*versions)+setup';
                $value = "['product-option-taskqty','product-option-setuptime','product-option-taskdesc','required-entry product-option-machineid']";
                break;
            
            case self::FORMULA_TYPE_HOURLY:
                //$value = '(taskqty*rate)+setup';
                $value = "['product-option-taskqty','product-option-taskdesc','required-entry product-option-machineid']";
                break;
            
            case self::FORMULA_TYPE_HOURLY_PER_VERSION:
                //$value = '(taskqty*rate*versions)+setup';
                $value = "['product-option-taskqty','product-option-taskdesc','required-entry product-option-machineid']";
                break;
        }
        
        return $value;
    }
}
