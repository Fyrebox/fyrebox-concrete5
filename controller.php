<?php
namespace Concrete\Package\Fyrebox;

use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Package\Package;
use Concrete\Core\Page\Page;
use Concrete\Core\Page\Single;
use Exception;

class Controller extends Package
{
    protected $pkgHandle = 'fyrebox';
    protected $appVersionRequired = '5.7.5';
    protected $pkgVersion = '1.0.3';

    protected $single_pages = [
        '/dashboard/fyrebox' => [
            'cName' => 'Fyrebox',
        ],
        '/dashboard/fyrebox/settings' => [
            'cName' => 'Fyrebox Settings',
        ],
    ];

    public function getPackageName()
    {
        return t('Fyrebox Quiz');
    }

    public function getPackageDescription()
    {
        return t('Display a Fyrebox Quiz');
    }

    public function install()
    {
        $pkg = parent::install();
        $this->installEverything($pkg);
    }

    public function upgradeCoreData()
    {
        if (version_compare($this->pkgVersion, 2.0, '<')) {
            throw new Exception(t("This version is not backwards compatible. Uninstall the previous version first to be able to install this version."));
        }

        parent::upgradeCoreData();
    }

    public function upgrade()
    {
        $pkg = parent::getByHandle($this->pkgHandle);
        $this->installEverything($pkg);
    }

    public function installEverything($pkg)
    {
        $this->installBlockTypes($pkg);
        $this->installPages($pkg);
    }

    public function installBlockTypes($pkg)
    {
        if (!BlockType::getByHandle("fyrebox")) {
            BlockType::installBlockType('fyrebox', $pkg);
        }
    }

    protected function installPages($pkg)
    {
        foreach ($this->single_pages as $path => $value) {
            if (!is_array($value)) {
                $path = $value;
                $value = [];
            }

            $page = Page::getByPath($path);
            if (!$page || $page->isError()) {
                $single_page = Single::add($path, $pkg);

                if ($value) {
                    $single_page->update($value);
                }
            }
        }
    }
}
