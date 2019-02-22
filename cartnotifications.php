<?php
include 'Promedeli/bootstrap.php';
include 'src/NotificationService.php';

use Cartnotifications\NotificationService;
use Promedeli\Model\Config;
use Promedeli\Service\ConfigManager;
use Promedeli\Service\FrontendResourceManager;
use Promedeli\Service\ConfigStoragePSDefault;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Cartnotifications extends Module
{
    private $adminContent;
    private $config;
    private $frontendResourceManager;
    private $notificationService;

    public function __construct()
    {
        $this->name = 'cartnotifications';

        $this->tab = 'front_office_features';
        $this->version = '1.0.1';
        $this->author = 'Promedeli';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = ['min' => '1.6', 'max' => _PS_VERSION_];
        $this->bootstrap = true;
        $this->module_key = '';

        parent::__construct();

        /**
         * Create config of the module
         */
        $this->config = new Config($this->name);
        $this->config->setPrestashopVersion(_PS_VERSION_);
        $this->config->setContext($this->context);
        $this->config->setStorage(new ConfigStoragePSDefault(Configuration::class, $this->name));

        /**
         * Create Frontend resource manager
         */
        $this->frontendResourceManager = new FrontendResourceManager($this->config);

        $this->displayName = $this->l('Cart notifications');
        $this->description = $this->l('Module helps increase sales in your shop and customer satisfaction by displaying dynamic, actionable messages in cart');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module?');

        $this->setUpNotification();
    }

    public function install()
    {
        $this->_clearCache('*');

        $status = parent::install() && $this->registerHook('header');

        $configuration = $this->getDefaultConfiguration();
        $this->config->setParams($configuration);

        $configManager = new ConfigManager(Configuration::class);
        $configManager->storeAllParams($this->config);

        return $status;
    }


    public function uninstall()
    {
        if (!parent::uninstall()) {
            return false;
        }

        return true;
    }

    private function setUpNotification()
    {
        /**
         * Filter pages allowed to show notification
         */
        $pagesAllowedToShow = array_filter([
            $this->config->show_on_cart_page ? 'cart' : null,
            $this->config->show_on_product_page ? 'product' : null,
            $this->config->show_on_category_page ? 'category' : null,
        ], function ($v) {
            return !empty($v);
        });

        if (in_array($this->context->controller->php_self, $pagesAllowedToShow)) {
            $this->notificationService = new NotificationService($this->config);
            $message = $this->notificationService->parseMessage();

            $this->context->smarty->assign('enable_button', $this->config->enable_button);
            $this->context->smarty->assign('button_link_url', $this->config->button_link_url);
            $this->context->smarty->assign('animation', $this->config->animation);
            $this->context->smarty->assign('animation_delay', $this->config->animation_delay);

            $this->context->smarty->assign('text', $message);

            if ($this->notificationService->shouldBeDisplayed()) {
                $this->context->controller->info = $this->smarty->smarty->fetch(dirname(__FILE__) . '/views/templates/front/message.tpl');
            }
        }
    }

    public function hookHeader()
    {
        $this->frontendResourceManager->addJs($this->config->getModuleName());
    }


    public function getDefaultConfiguration()
    {
        return [

            'show_on_cart_page' => true,
            'show_on_product_page' => true,
            'show_on_category_page' => true,

            'text' => 'Add ${leftTo: 250} to your cart in order to receive free shipping',
            'enable_button' => true,
            'button_link_url' => '/',
            'minutes_word' => 'minutes',
            'hours_word' => 'hours',
            'animation' => 'none',
            'animation_delay' => 1
        ];
    }

    public function getContent()
    {
        if ($this->postValidation()) {

            $currentConfiguration = $this->getDefaultConfiguration();
            foreach ($currentConfiguration as $key => $value) {
                $this->config->getStorage()->saveParam($key, Tools::getValue($key));
            }

            $this->adminContent .= $this->displayConfirmation($this->l('Settings updated'));
        }

        return $this->adminContent . $this->displayForm() . $this->customerSupportButton();
    }

    protected function postValidation()
    {
        $errors = [];

        if (Tools::isSubmit('submit' . $this->name)) {


            if (empty(Tools::getValue('text'))) {
                $errors[] = $this->getTranslator()->trans('Invalid value for "Notification text" field is required and should be text',
                    [],
                    'Modules.Cartnotifications.Admin');
            }

            if (empty(Tools::getValue('minutes_word'))) {
                $errors[] = $this->getTranslator()->trans('Invalid value for "Minutes word" field is required and should be text',
                    [],
                    'Modules.Cartnotifications.Admin');
            }

            if (empty(Tools::getValue('hours_word'))) {
                $errors[] = $this->getTranslator()->trans('Invalid value for "Hours word" field is required and should be text',
                    [],
                    'Modules.Cartnotifications.Admin');
            }


            if (Tools::getValue('enable_button') == 1 && empty(Tools::getValue('button_link_url'))) {
                $errors[] = $this->getTranslator()->trans('Invalid value for "Button link url" field is required and should be text',
                    [],
                    'Modules.Cartnotifications.Admin');
            }


        } else {
            return false;
        }

        /* Display errors if needed */
        if (count($errors)) {
            $this->adminContent .= $this->displayError(implode('<br />', $errors));
            return false;
        }

        /* Returns if validation is ok */
        return true;
    }

    public function displayForm()
    {

        $formFields = [];

        require 'config/config_form.php';

        $helper = new HelperForm();

        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        $helper->title = $this->displayName;
        $helper->show_toolbar = true;
        $helper->toolbar_scroll = true;
        $helper->submit_action = 'submit' . $this->name;
        $helper->toolbar_btn = [
            'save' =>
                [
                    'desc' => $this->l('Save'),
                    'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name .
                        '&token=' . Tools::getAdminTokenLite('AdminModules'),
                ],
            'back' => [
                'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            ]
        ];

        foreach ($this->getDefaultConfiguration() as $key => $value) {
            $helper->fields_value[$key] = $this->config->getParam($key);
        }

        return $helper->generateForm($formFields);
    }

    public function customerSupportButton()
    {
        return $this->display(__FILE__, '../admin/footer.tpl');
    }

}
