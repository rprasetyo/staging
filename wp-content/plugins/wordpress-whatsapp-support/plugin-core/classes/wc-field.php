<?php

// Preventing to direct access
defined('ABSPATH') OR die('Direct access not acceptable!');

if ( ! class_exists('Wecreativez_Core_Field')):

    class Wecreativez_Core_Field {

        public function add($field_type, $args = array()) {

            $argument = $this->arguments($args);
            
            ?>

            <tr>
                <th scope="row">
                    <label for="<?php echo $argument['name'] ?>">
                        <?php echo $argument['label'] ?>
                    </label>
                    <?php $this->tooltip($argument['tooltip']);?>
                </th>
                <td>
                    <?php
                        $this->field($field_type, $argument);
                        $this->description($argument['desc']);
                     ?>
                </td>
            </tr>
            
            <?php

        }

        public function field($field_type, $argument = array()) {

            switch ($field_type) {

            case 'text':

                printf('<input id="%1$s" name="%1$s" type="text"  value="%2$s" class="regular-text %3$s" placeholder="%4$s" %5$s>',
                    $argument['name'],
                    $argument['value'],
                    $argument['class'],
                    $argument['placeholder'],
                    $argument['required']
                );

                break;

            case 'password':

                printf('<input id="%1$s" name="%1$s" type="password"  value="%2$s" class="regular-text %3$s" placeholder="%4$s">',
                    $argument['name'],
                    $argument['value'],
                    $argument['class'],
                    $argument['placeholder']
                );

                break;

            case 'number':

                printf('<input id="%1$s" name="%1$s" type="number" min="%5$s" max="%6$s" step="%7$s" value="%2$s" class="%8$s %3$s" placeholder="%4$s">',
                    $argument['name'],
                    $argument['value'],
                    $argument['class'],
                    $argument['placeholder'],
                    $argument['min'],
                    $argument['max'],
                    $argument['step'],
                    $argument['field_size']
                );

                break;

            case 'email':

                printf('<input id="%1$s" name="%1$s" type="email"  value="%2$s" class="regular-text %3$s" placeholder="%4$s">',
                    $argument['name'],
                    $argument['value'],
                    $argument['class'],
                    $argument['placeholder']
                );

                break;

            case 'color':

                printf('<input id="%1$s" name="%1$s" type="text"  value="%2$s" class="wecreativez-color-field %3$s">',
                    $argument['name'],
                    $argument['value'],
                    $argument['class']
                );

                break;

            case 'textarea':

                printf('<textarea id="%1$s" name="%1$s" class="regular-text %3$s" rows="%5$s" placeholder="%4$s">%2$s</textarea>',
                    $argument['name'],
                    $argument['value'],
                    $argument['class'],
                    $argument['placeholder'],
                    $argument['rows']
                );

                break;

            case 'select':

                if ($argument['select2'] == true) {
                    echo "<select name='{$argument['name']}' id='{$argument['id']}' class='regular-text wecreativez-multi-select {$argument['class']}'>";
                } else {
                    echo "<select name='{$argument['name']}' id='{$argument['id']}' class='{$argument['class']}'>";
                }

                foreach ($argument['option'] as $key => $value) {
                    if ($argument['selected'] == $key) {
                        echo "<option value='{$key}' selected>{$value}</option>";
                    } else {
                        echo "<option value='{$key}'>{$value}</option>";
                    }

                }
                echo "<select>";

                break;

            case 'select-multiple':

                echo "<select name='{$argument['name']}' class='regular-text wecreativez-multi-select' multiple>";
                foreach ($argument['option'] as $key => $value) {
                    if (in_array($key, $argument['selected'])) {
                        echo "<option value='{$key}' selected>{$value}</option>";
                    } else {
                        echo "<option value='{$key}'>{$value}</option>";
                    }

                }
                echo "<select>";

                break;

            case 'checkbox':

                echo "<fieldset>";
                echo "<legend class='screen-reader-text'><span>{$argument['label']}</span></legend>";
                echo "<label for='{$argument['name']}'>";

                if ($argument['value'] == '1') {
                    echo "<input name='{$argument['name']}' type='checkbox' id='{$argument['name']}' value='1' checked>";
                } else {
                    echo "<input name='{$argument['name']}' type='checkbox' id='{$argument['name']}' value='0'>";
                }

                echo " {$argument['checkbox_text']}";
                echo "</label>";
                echo "</fieldset>";

                break;

            case 'checkbox-multiple':

                echo "<fieldset>";
                echo "<legend class='screen-reader-text'><span>{$argument['label']}</span></legend>";

                foreach ($argument['option'] as $key => $value) {

                    echo "<label for='{$value['name']}'>";

                    if ($value['value'] == '1') {
                        echo "<input name='{$value['name']}' type='checkbox' id='{$value['name']}' value='1' checked>";
                    } else {
                        echo "<input name='{$value['name']}' type='checkbox' id='{$value['name']}' value='0'>";
                    }

                    echo " {$value['checkbox_text']}";
                    echo "</label><br>";

                }

                echo "</fieldset>";

                break;

            case 'radio':

                echo "<fieldset>";
                echo "<legend class='screen-reader-text'><span>{$argument['label']}</span></legend>";

                foreach ($argument['option'] as $key => $value) {

                    echo "<label for='{$argument['name']}'>";

                    if ($value['value'] == $argument['selected']) {
                        echo "<input name='{$argument['name']}' type='radio' id='{$argument['name']}' value='{$value['value']}' checked>";
                    } else {
                        echo "<input name='{$argument['name']}' type='radio' id='{$argument['name']}' value='{$value['value']}'>";
                    }

                    echo " {$value['radio_text']}";

                    if ($argument['radio_inline'] != true) {
                        echo "</label><br>";
                    } else {
                        echo "</label><span style='margin-right: 25px;'></span>";
                    }

                }

                echo "</fieldset>";

                break;

            case 'wp_editor':

                echo "<div style='width: 550px; max-width: 100%;'>";
                wp_editor(
                    stripslashes($argument['value']),
                    $argument['id'],
                    array(
                        'media_buttons' => false,
                        'editor_height' => $argument['wp_editor_height'],
                        'editor_class'  => 'regular-text',
                        'textarea_name' => $argument['name'],
                        'wpautop'       => false,
                    )
                );
                echo "</div>";

                break;

            case 'file':

                echo "<input type='text' name='{$argument['name']}' data-wecreativez-upload-url-id='{$argument['id']}' class='regular-text' value='{$argument['value']}'>";
                echo "<input type='button' data-wecreativez-upload-id='{$argument['id']}' class='button-secondary' value='" . esc_html__( 'Upload Image' ) . "'>";

                break;

            default:

                printf('<input id="%1$s" name="%1$s" type="text"  value="%2$s" class="regular-text %3$s" placeholder="%4$s">',
                    $argument['name'],
                    $argument['value'],
                    $argument['class'],
                    $argument['placeholder']
                );

                break;
            }

        }

        public function arguments($args = array()) {

            return array(
                'id'               => (isset($args['id'])) ? $args['id'] : '',
                'label'            => (isset($args['label'])) ? $args['label'] : '',
                'value'            => (isset($args['value'])) ? $args['value'] : '',
                'name'             => (isset($args['name'])) ? $args['name'] : '',
                'placeholder'      => (isset($args['placeholder'])) ? $args['placeholder'] : '',
                'tooltip'          => (isset($args['tooltip'])) ? $args['tooltip'] : '',
                'class'            => (isset($args['class'])) ? $args['class'] : '',
                'desc'             => (isset($args['desc'])) ? $args['desc'] : '',
                'option'           => (isset($args['option'])) ? $args['option'] : array(),
                'selected'         => (isset($args['selected'])) ? $args['selected'] : '',
                'min'              => (isset($args['min'])) ? $args['min'] : '',
                'max'              => (isset($args['max'])) ? $args['max'] : '',
                'step'             => (isset($args['step'])) ? $args['step'] : '',
                'checkbox_text'    => (isset($args['checkbox_text'])) ? $args['checkbox_text'] : '',
                'radio_text'       => (isset($args['radio_text'])) ? $args['radio_text'] : '',
                'radio_inline'     => (isset($args['radio_inline'])) ? true : false,
                'wp_editor_height' => (isset($args['wp_editor_height'])) ? $args['wp_editor_height'] : '300',
                'rows'             => (isset($args['rows'])) ? $args['rows'] : '4',
                'select2'          => (isset($args['select2'])) ? true : false,
                'required'         => (isset($args['required'])) ? 'required' : '',
                'field_size'       => (isset($args['field_size'])) ? $args['field_size'] : 'regular-text',
            );

        }

        /**
         * Render description
         * @param  string $desc
         * @since 1.0
         */
        public function description($desc) {

            if ( ! $desc) {
                return;
            }

            echo '<p class="description">' . $desc . '</p>';

        }

        /**
         * Render tooltip
         * @param  string $tooltip
         * @since 1.0
         */
        public function tooltip($tooltip) {

            if ( ! $tooltip) {
                return;
            }

            echo '<span class="dashicons dashicons-info wecreativez-admin-tooltip" data-tippy-content="' . $tooltip . '"></span>';

        }

    } // end Wecreativez_Core_Field

endif;