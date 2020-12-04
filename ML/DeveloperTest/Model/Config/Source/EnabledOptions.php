<?php

namespace ML\DeveloperTest\Model\Config\Source;

//use Magento\Framework\Option\ArrayInterface;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class EnabledOptions
 * @package ML\DeveloperTest\Config\Model\Source
 * @author Kashif <kash@dreamsites.co.uk>
 */
class EnabledOptions implements OptionSourceInterface
{

    const ENABLED = 1;
    const DISABLED = 0;

    /**
     * @return array
     */
    public static function getOptionArray()
    {
        return [
            self::ENABLED => __('Enabled'),
            self::DISABLED => __('Disabled')
        ];
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $res = [];
        foreach (self::getOptionArray() as $index => $value) {
            $res[] = ['value' => $index, 'label' => $value];
        }
        return $res;
    }

}
