<?php
class BroSolutions_CustomOption_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * 
     * @return array
     */
    public function getPrintedOptionTypes(){
        return array(
            'size'=>'Size',
            'number_of_pages'=>'Number of Pages',
            'quantity_breaks'=>'Quantity Breaks',
            'quantity_ranges'=>'Quantity Ranges',
            'ink_color'=>'Ink Colors',
            'misc'=>'Miscellaneous',
            'paperstock'=>'Paperstock',
            'proof_options'=>'Proof Options',
            'finishing'=>'Finishing',
            'turnaround'=>'Turnaround',
            'file_upload'=>'File Upload',
        );
    }
    
    public function getSelectTypes()
    {
        return array('size',
            'number_of_pages',
            'quantity_breaks',
            'ink_color',
            'misc',
            'paperstock',
            'proof_options',
            'turnaround',
            'file_upload',
            'quantity_ranges',);
    }
    
    
    public function getValueTitle($value)
    {
        if(is_array($value)){
            $value = new Varien_Object($value);
        }
        $unserialised = @unserialize($value->getSerialisedValues());
        if(is_array($unserialised)){
            $value->addData($unserialised);
        }
        $a = $value->getOption()->getType();
        switch($value->getOption()->getType()){
            case 'proof_options':
                $title = $value->getDescription();
                break;

            case 'paperstock':
                $title = $value->getPaperDesc();
                break;
            
            case 'turnaround':
                $title = $value->getTurnaround();
                break;
            
            case 'ink_color':
                if($value->getOption()->getUseCustomTitle()){
                    $title = $value->getCustomtitle();
                } else {
                    $title = $value->getFront().'/'.$value->getBack();
                }
                break;

            case 'finishing':
                
                $title = $value->getTaskdesc();
                break;

            default:
                $title = $value->getTitle();
        }
        
        return $title;
    }
    
    
    public function getOptionTitle($option)
    {
        switch($option->getType()){
            case 'finishing':
                $values = $option->getValues();
                $value = array_shift($values);
                $departmentId = $value->getDepartment();
                $department = Mage::getModel('brocustomoption/department')->load($departmentId);
                $title = $department->getName();
                break;
            
            default:
                $title = $option->getTitle();
        }
        return $title;
    }
    
    
    public function sortOption($opt1, $opt2)
    {
        if($opt1->getType() == 'quantity_breaks' || $opt1->getType() == 'quantity_ranges'){
            return -1;
        }elseif($opt2->getType() == 'quantity_breaks' || $opt2->getType() == 'quantity_ranges'){
            return 1;
        } else {
            return 0;
        }
    }
    
    
    public function sortOptions($options)
    {
        $res = array();
        foreach($options as $key => $option){
            if($option->getType() == 'quantity_breaks' || $option->getType() == 'quantity_ranges')
                $res[$key] = $option;
        }
        foreach($options as $key => $option){
            if(!key_exists($key, $res))
                    $res[$key] = $option;
        }
        
        return $res;
    }
    
    
    public function checkType($type)
    {
        $name = $type->getName();
        return in_array($name, $this->_getAllowedTypes());
    }
    
    
    protected function _getAllowedTypes()
    {
        return array(
            'size',
            'number_of_pages',
            'quantity_breaks',
            'quantity_ranges',
            'ink_color',
            'misc',
            'paperstock',
            'proof_options',
            'finishing',
            'turnaround',
            'file_upload',
        );        
    }
}
	 