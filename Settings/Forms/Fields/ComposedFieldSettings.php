<?php


namespace RNAUTO\Settings\Forms\Fields;


use RNAUTO\Utilities\Sanitizer;

class ComposedFieldSettings extends FieldSettingsBase
{
    /** @var ComposedFieldRow[] */
    public $Rows;
    /** @var ComposedFieldRow */
    private $_currentRow;

    /**
     * ComposedFieldSettings constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->Rows=[];
        $this->_currentRow=null;
        $this->RendererType='Composed';

    }

    public function CreateRow(){
        $row=new ComposedFieldRow($this);
        $this->Rows[]=$row;
        $this->_currentRow=$row;
    }

    private function GetCurrentRow(){
        if($this->_currentRow==null)
            $this->CreateRow();

        return $this->_currentRow;
    }

    /**
     * @param $item ComposedFieldItem
     */
    public function AddComposedFieldItem($item)
    {
        $row=$this->GetCurrentRow();
        $item->SetParent($row);
        $row->Items[]=$item;
    }

    public function AddItem($id,$path,$label)
    {
        $row=$this->GetCurrentRow();
        $row->Items[]=new ComposedFieldItem($row,$id,$path,$label);

    }

    public function InitializeFromOptions($options)
    {
        $this->Rows=[];
        foreach($options->Rows as $currentRow)
        {
            $composedItem=new ComposedFieldRow($this);
            $composedItem->InitializeFromOptions($currentRow);
            $this->Rows[]=$composedItem;
        }

        parent::InitializeFromOptions($options); // TODO: Change the autogenerated stub
    }

    public function GetTemplatePath()
    {
        return 'Fields/Composed/'.$this->RendererType.'.twig';
    }



    public function GetType()
    {
        return 'Composed';
    }

    public function GetDataSections($mode = 'Filter')
    {
        $sections= [new DataSection($this->Id,$this->Label,'Value',['value'])];


        foreach($this->Rows as $currentRow)
        {
            foreach($currentRow->Items as $currentItem)
            {
                $sections[]=new DataSection($this->Id,$currentItem->Label,$currentItem->Id,$currentItem->Path);
            }
        }
        return $sections;
    }



}


