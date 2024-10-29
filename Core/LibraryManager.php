<?php

namespace RNAUTO\Core;


class LibraryManager
{
    /** @var Loader */
    public $Loader;

    public $dependencies = [];

    public function __construct($loader)
    {
        $this->Loader = $loader;
    }

    public static function GetInstance(){
        return new LibraryManager(apply_filters('allinoneforms_get_loader',null));
    }

    public function GetDependencyHooks(){
        $hooks=[];
        foreach($this->dependencies as $currentDependency)
        {
            $hooks[]=\str_replace('@',$this->Loader->Prefix.'_',$currentDependency);
        }
        return $hooks;
    }

    public function AddHTMLGenerator(){
        self::AddLit();
        $this->Loader->AddScript('htmlgenerator','js/dist/RNAUTOHTMLGenerator_bundle.js',array('@pageBuilder','@lit'));

    }

    public function AddDropdownButton(){
        self::AddLit();
        self::AddCore();
        $this->Loader->AddScript('dropdownbutton','js/dist/RNAUTODropDownButton_bundle.js',array('@Core'));
        $this->Loader->AddStyle('dropdownbutton','js/dist/RNAUTODropDownButton_bundle.css');

        $this->AddDependency('@dropdownbutton');

    }


    public function AddTooltip(){
        self::AddLit();
        self::AddFormBuilderCore();
        $this->Loader->AddScript('tooltip','js/dist/RNAUTOTooltip_bundle.js',array('@lit','@Core'));
        $this->Loader->AddStyle('tooltip','js/dist/RNAUTOTooltip_bundle.css');
    }
    private function AddDependency($dependency)
    {
        if (!in_array($dependency, $this->dependencies))
            $this->dependencies[] = $dependency;
    }

    public function AddConditionalFieldSet(){
        self::AddSwitchContainer();
        $this->Loader->AddScript('conditionalfieldset','js/dist/RNAUTOConditionalFieldSet_bundle.js',array('@switchcontainer'));
        $this->AddDependency('@conditionalfieldset');
    }

    public function AddSingleLineGenerator()
    {
        $this->Loader->AddScript('singlelinegenerator','js/dist/RNAUTOSingleLineGenerator_bundle.js');
        $this->AddDependency('@singlelinegenerator');

    }

    public function AddSwitchContainer(){
        self::AddLit();
        $this->Loader->AddScript('switchcontainer','js/dist/RNAUTOSwitchContainer_bundle.js',array('@lit'));
        $this->AddDependency('@switchcontainer');

    }


    public function AddInputs(){
        self::AddLit();
        self::AddCore();
        self::AddSelect();
        $this->Loader->AddScript('date','js/lib/date/flatpickr.js',array('@lit'));
        $this->Loader->AddStyle('date','js/lib/date/flatpickr.min.css');
        $this->Loader->AddScript('inputs','js/dist/RNAUTOInputs_bundle.js',array('@lit','@select','@date'));
        $this->Loader->AddStyle('inputs','js/dist/RNAUTOInputs_bundle.css');

        $this->AddDependency('@inputs');

    }

    public function AddAlertDialog(){
        self::AddLit();
        self::AddCore();
        self::AddDialog();
        $this->Loader->AddScript('AlertDialog','js/dist/RNAUTOAlertDialog_bundle.js',array('@lit','@Dialog','@Core'));
        $this->Loader->AddStyle('AlertDialog','js/dist/RNAUTOAlertDialog_bundle.css');
        $this->AddDependency('@AlertDialog');

    }

    public function AddTextEditor(){
        self::AddLit();
        self::AddDialog();
        self::AddInputs();
        self::AddAccordion();
        $this->Loader->AddScript('texteditor','js/dist/RNAUTOTextEditor_bundle.js',array('@lit','@Dialog','@inputs'));
        $this->Loader->AddStyle('texteditor','js/dist/RNAUTOTextEditor_bundle.css');
        $this->AddDependency('@texteditor');

    }
    public function AddCore(){
        self::AddLoader();
        self::AddLit();
        $this->Loader->AddScript('Core', 'js/dist/RNAUTOCore_bundle.js', array('@loader', '@lit'));
        $this->AddDependency('@Core');
    }

    public function AddFormulas(){
        self::AddFormBuilderCore();
        $this->Loader->AddScript('Formula','js/dist/RNAUTOormulaCore_bundle.js',array('@FormBuilderCore'));
        $this->AddDependency('@Formula');
    }



    public function AddFormBuilderCore(){
        self::AddCore();
        self::AddDialog();

    }

    public function AddLoader()
    {
        $this->Loader->AddScript('loader', 'js/lib/loader.js');
        $this->AddDependency('@loader');
    }

    public function AddSelect(){
        $this->Loader->AddScript('select','js/lib/tomselect/js/tom-select.complete.js');
        $this->Loader->AddStyle('select','js/lib/tomselect/css/tom-select.bootstrap5.css');
        $this->AddDependency('@select');
    }

    public function AddCarousel(){
        $this->Loader->AddScript('carousel','js/lib/Swiper/swiper-bundle.min.js');
    }


    public function AddLit()
    {
        self::AddLoader();
        $this->Loader->AddScript('lit', 'js/dist/RNAUTOLit_bundle.js', array('@loader'));
        $this->AddDependency('@lit');
    }

    public function AddCoreUI()
    {
        self::AddCore();
        $this->Loader->AddScript('CoreUI', 'js/dist/RNAUTOCoreUI_bundle.js', array('@Core'));
        $this->Loader->AddStyle('CoreUI', 'js/dist/RNAUTOCoreUI_bundle.css');

        $this->AddDependency('@CoreUI');
    }

    public function AddTranslator($fileList)
    {
        $this->Loader->AddRNTranslator($fileList);
        $this->AddDependency('@RNTranslator');
    }

    public function AddDialog()
    {
        self::AddLit();
        self::AddCore();
        $this->Loader->AddScript('Dialog', 'js/dist/RNAUTODialog_bundle.js', array('@lit','@Core'));
        $this->Loader->AddStyle('Dialog', 'js/dist/RNAUTODialog_bundle.css');
        $this->AddDependency('@Dialog');
    }

    public function AddContext(){
        self::AddLit();
        $this->Loader->AddScript('Context','js/dist/RNAUTOContext_bundle.js');
        $this->Loader->AddStyle('Context','js/dist/RNAUTOContext_bundle.css');
    }

    public function AddPreMadeDialog(){
        self::AddDialog();
        self::AddSpinner();
        $this->Loader->AddScript('PreMadeDialog', 'js/dist/RNAUTOPreMadeDialogs_bundle.js', array('@Dialog'));

    }

    public function AddContextMenu(){
        self::AddLit();
        $this->Loader->AddScript('ContextMenu','js/dist/RNAUTOContextMenu_bundle.js',array('@lit'));
        $this->Loader->AddStyle('ContextMenu','js/dist/RNAUTOContextMenu_bundle.css');
        $this->AddDependency('@ContextMenu');
    }

    public function AddDate(){
        self::AddLit();;
        $this->Loader->AddScript('date','js/lib/date/flatpickr.js',array('@lit'));
        $this->Loader->AddStyle('date','js/lib/date/flatpickr.min.css');
        $this->AddDependency('@date');
    }

    public function AddAccordion()
    {
        self::AddLit();
        $this->Loader->AddScript('Accordion', 'js/dist/RNAUTOAccordion_bundle.js', array('@lit'));
        $this->Loader->AddStyle('Accordion', 'js/dist/RNAUTOAccordion_bundle.css');
        $this->AddDependency('@Accordion');
    }


    public function AddTabs()
    {
        $this->AddLit();
        $this->Loader->AddScript('Tabs', 'js/dist/RNAUTOTabs_bundle.js', array('@lit'));
        $this->Loader->AddStyle('Tabs', 'js/dist/RNAUTOTabs_bundle.css');

        $this->AddDependency('@Tabs');
    }

    public function AddCalendar(){
        $this->Loader->AddScript('calendar','js/lib/calendar/main.js');
        $this->Loader->AddStyle('calendar','js/lib/calendar/main.css');
        $this->AddDependency('@calendar');
    }

    public function AddSpinner(){
        self::AddLit();
        self::AddCore();
        $this->Loader->AddScript('Spinner', 'js/dist/RNAUTOSpinnerButton_bundle.js', array('@lit','@Core'));
        $this->Loader->AddStyle('Spinner', 'js/dist/RNAUTOSpinnerButton_bundle.css');
    }

    public function AddWPTable()
    {
        self::AddCore();
        $this->Loader->AddScript('WPTable', 'js/dist/RNAUTOWPTable_bundle.js', array('@Core'));
        $this->Loader->AddStyle('WPTable', 'js/dist/RNAUTOWPTable_bundle.css');
        $this->AddDependency('@WPTable');
    }

    public function AddPageBuilder()
    {
    //    $this->AddPage();
        $this->AddDialog();
        //$this->AddHTMLRenderer();
        $this->AddContextMenu();
        //$this->AddGridFieldBlock();
        //$this->AddFormFieldBlock();
        //$this->AddTextFieldBlock();
        //$this->AddNavigatorFieldBlock();
        //$this->AddSearchBarBlock();
        //$this->AddFormBlock();;
        $this->AddPreMadeDialog();
        //$this->AddCalendarBlock();
        //$this->AddImageBlock();
        //$this->AddListBlock();
        $this->AddTabs();
        $this->AddAccordion();
        $this->AddInputs();
        $this->AddHTMLGenerator();
        $this->Loader->AddScript('pageBuilder','js/dist/RNAUTOPageBuilder_bundle.js',$this->GetDependencyHooks());
        $this->Loader->AddStyle('pageBuilder','js/dist/RNAUTOPageBuilder_bundle.css');
        $this->AddDependency('@pageBuilder');

    }

    public function AddFormBlock(){
        $this->Loader->AddScript('formblock','js/dist/RNAUTOormBlock_bundle.js');
        $this->AddDependency('@formblock');
    }

    public function AddCalendarBlock(){
        $this->Loader->AddScript('calendarblock','js/dist/RNAUTOCalendarBlock_bundle.js');
        $this->AddDependency('@calendarblock');
    }

    public function AddListBlock(){
        $this->Loader->AddScript('listblock','js/dist/RNAUTOListBlock_bundle.js');
        $this->AddDependency('@listblock');
    }

    public function AddImageBlock(){
        $this->Loader->AddScript('imageblock','js/dist/RNAUTOImageBlock_bundle.js');
        $this->AddDependency('@imageblock');
    }

    public function AddSearchBarBlock(){
        $this->Loader->AddScript('searchbarblock','js/dist/RNAUTOSearchBarBlock_bundle.js');
        $this->AddDependency('@searchbarblock');
    }

    public function AddHTMLRenderer()
    {
        $this->Loader->AddScript('htmlrenderer','js/dist/RNAUTOHtmlRenderer_bundle.js');
        $this->AddDependency('@htmlrenderer');
    }

    public function AddFormFieldBlock(){
        $this->Loader->AddScript('formfieldblock','js/dist/RNAUTOormFieldBlock_bundle.js');
        $this->Loader->AddStyle('formfieldblock','js/dist/RNAUTOormFieldBlock_bundle.css');
        $this->AddDependency('@formfieldblock');
    }

    public function AddNavigatorFieldBlock(){

        $this->Loader->AddScript('navigatorfieldblock','js/dist/RNAUTONavigatorFieldBlock_bundle.js');
        $this->Loader->AddStyle('navigatorfieldblock','js/dist/RNAUTONavigatorFieldBlock_bundle.css');
        $this->AddDependency('@navigatorfieldblock');
    }

    public function AddTextFieldBlock(){
        $this->Loader->AddScript('textfieldblock','js/dist/RNAUTOTextFieldBlock_bundle.js');
        $this->Loader->AddStyle('textfieldblock','js/dist/RNAUTOTextFieldBlock_bundle.css');
        $this->AddDependency('@textfieldblock');
    }

    public function AddGridFieldBlock(){
        $this->Loader->AddScript('gridfieldblock','js/dist/RNAUTOGridFieldBlock_bundle.js');
        $this->AddDependency('@gridfieldblock');
    }


    private function AddPage()
    {
        $this->Loader->AddScript('page','js/dist/RNAUTORNPage_bundle.js');
        $this->Loader->AddStyle('page','js/dist/RNAUTORNPage_bundle.css');
        $this->AddDependency('@page');
    }
}