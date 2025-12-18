<?php
class Form
{
    private $fields = array();
    private $action;
    private $submit = "Submit Form";
    private $jumField = 0;

    public function __construct($action, $submit)
    {
        $this->action = $action;
        $this->submit = $submit;
    }

    public function addField($name, $label, $type="text", $value="", $required=true)
    {
        $this->fields [$this->jumField] = [
            'type' => $type,
            'name' => $name,
            'label' => $label,
            'value' => $value,
            'required' => $required
        ];
        $this->jumField ++;
    }

    public function addSelect($name, $label, $options, $selectedValue="", $required=true)
    {
        $this->fields [$this->jumField] = [
            'type' => 'select',
            'name' => $name,
            'label' => $label,
            'options' => $options,
            'selected' => $selectedValue,
            'required' => $required
        ];
        $this->jumField ++;
    }

    public function displayForm()
    {
        echo "<form action='". $this->action . "' method='POST' enctype='multipart/form-data'>";
        echo '<div class="main">';
        
        for ($j=0; $j<count($this->fields); $j++) {
            $field = $this->fields[$j];
            
            if ($field['type'] == 'hidden') {
                echo "<input type='hidden' name='{$field['name']}' value='". htmlspecialchars($field['value']) . "' />";
                continue;
            }

            $required = $field['required'] ? 'required' : '';
            // FIX: Mengatasi Undefined Array Key 'value'
            $value = htmlspecialchars($field['value'] ?? ''); 
            
            echo '<div class="input">';
            echo '<label>' . htmlspecialchars($field['label']) . '</label>';

            if ($field['type'] == 'select') {
                echo "<select name='{$field['name']}' {$required}>";
                echo "<option value=''>-- Pilih {$field['label']} --</option>";
                foreach ($field['options'] as $opt) {
                    $selected = ($field['selected'] == $opt) ? 'selected' : '';
                    echo "<option value='{$opt}' {$selected}>{$opt}</option>";
                }
                echo "</select>";
            } else {
                echo "<input type='{$field['type']}' name='{$field['name']}' value='{$value}' {$required}/>";
            }
            echo '</div>';
        }
        
        echo "<div class='submit'>";
        echo "<input type='submit' name='submit' value='". $this->submit . "' />";
        echo "</div>";
        echo "</div>";
        echo "</form>"; 
    }
}