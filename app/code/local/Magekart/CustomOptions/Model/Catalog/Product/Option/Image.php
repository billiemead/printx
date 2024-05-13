<?php

class Magekart_CustomOptions_Model_Catalog_Product_Option_Image {
    
    protected $_imageFile = '';
    protected $_width = 70;
    protected $_height = 70;
    
    public function init($imageFile) {
        $this->_imageFile = $imageFile;
        return $this;
    }
    
    public function resize($width, $height = null) {
        $this->_width = $width;
        $this->_height = $height;        
        return $this;
    }
    
    public function setWatermarkSize($size) {
        return $this;
    }
    
    public function __toString() {
        $imgData = Mage::helper('customoptions')->getImgHtml($this->_imageFile, false, false, true, $this->_width);
        if (!$imgData) return '';
        return $imgData['url'];
    }

}