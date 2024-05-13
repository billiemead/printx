<?php


class Magekart_Adminhtml_Block_Customoptions_Options_Edit_Tab_Renderer_Prodcat extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row) {
        $text = array();
        $catIds = $row->getCatIds();
        $allCats = Mage::helper('customoptions')->getCategories();

        if ($catIds && is_string($catIds)) {
            foreach (explode(',', $catIds) as $id) {
                if (isset($allCats[$id])) {
                    $text[] = str_replace('&nbsp;', '', $allCats[$id]);
                }
            }
        }
        return implode(', ', $text);
    }
}