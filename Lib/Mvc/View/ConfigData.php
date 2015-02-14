<?php
/**
 * 
 * @author dknx01 <e.witthauer@gmail.com>
 * @since 13.02.15 17:32
 * @package
 * 
 */

namespace Mvc\View;


class ConfigData
{
    /**
     * @var \Mvc\Config\Definition\Config
     */
    private $config;

    /**
     * @var string
     */
    private $jsRoot;

    /**
     * @var string
     */
    private $cssRoot;

    public function __construct()
    {
        $this->config = \Mvc\System::getInstance()->configuration();
    }

    public function addExternalDataToView()
    {
        $externalFiles = $this->config->{"externals-sources"};
        if ($externalFiles) {
            if ($externalFiles->javascript) {
                $javascript = '';
                foreach ((array)$externalFiles->javascript as $js) {
                    $javascript .= '<script src="' . $js .'" type="text/javascript"></script>' . PHP_EOL;
                }
                \Mvc\System::getInstance()->set('externalJavascript', $javascript);
            }
            if ($externalFiles->css) {
                $cssString = '';
                foreach ($externalFiles->css as $css) {
                    $cssString .= '<link rel="stylesheet" href="' . $css . '">' . PHP_EOL;
                }
                \Mvc\System::getInstance()->set('externalCss', $cssString);
            }
        }
    }

    public function addJavascriptFilesFromConfig()
    {
        if ($this->config->getParam('javascript-files')) {
            $jsFiles = $this->config->getParam('javascript-files');
            if ($jsFiles['@attributes']['rootDirectory']) {
                $this->jsRoot = $jsFiles['@attributes']['rootDirectory'];
                unset($jsFiles['@attributes']);
            }

            if (is_array($jsFiles)) {
                foreach ($jsFiles as $file) {
                    \Mvc\System::getInstance()->viewHeader(
                        \Mvc\System::getInstance()->viewHeader() . PHP_EOL . $this->generateJsHeader($file)
                    );
                }
            }
        }
    }

    /**
     * @param string $file
     * @return string
     */
    private function generateJsHeader($file)
    {
        return '<script src="' . $this->jsRoot . '/' . $file . '" type="text/javascript"></script>';
    }

    public function addCssFilesFromConfig()
    {
        if ($this->config->getParam('css-files')) {
            $cssFiles = $this->config->getParam('css-files');
            if (isset($cssFiles['@attributes']['rootDirectory'])) {
                $this->cssRoot = $cssFiles['@attributes']['rootDirectory'];
                unset($cssFiles['@attributes']);
            }
            if (is_array($cssFiles)) {
                foreach ($cssFiles as $file) {
                    $additionalData = '';
                    if (is_array($file) && isset($file['@attributes'])) {
                        $additionalData = $file['@attributes'];
                        $fileName = $file['value'];
                    } else {
                        $fileName = $file;
                    }
                    $cssFile = $this->generateCssHeader($fileName, $additionalData);
                    \Mvc\System::getInstance()->viewHeader(
                        \Mvc\System::getInstance()->viewHeader() . PHP_EOL . $cssFile
                    );
                }
            }
        }
    }

    /**
     * @param string $file
     * @param array $additionalData
     * @return string
     */
    private function generateCssHeader($file, $additionalData)
    {
        $attributes = '';
        if (!empty($additionalData)) {
            foreach ($additionalData as $attribute => $value) {
                $attributes .= ' ' . $attribute . '="' . $value . '"';
            }
        }
        return '<link rel="stylesheet"' .
        $attributes .
        ' href="/' . $this->cssRoot . '/' . $file . '" >';
    }
}