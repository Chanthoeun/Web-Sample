<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// create_listing form
if(! function_exists('category_form')){
    function category_form($categories, $fieldName){        
        $str = '';
        $i = 1;
        if(count($categories)){
            
            foreach ($categories as $item){
                if($i > 4){
                    $str .= '</div>'.PHP_EOL;
                    $i = 1;
                }
                if($i == 1){
                    $str .= '<div class="row">';
                }
                $str .= '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">';
                $str .= '<strong>'.$item['caption'].'</strong>';
                // do we have children
                if(isset($item['children']) && count($item['children'])){
                    $str .= category_form_child($item['children'], $fieldName);
                }
                $str .= '</div>'.PHP_EOL;
                
                $i += 1;
            }
            if($i <= 4){
                $str .= '</div>'.PHP_EOL;
            }
        }
        
        return $str;
    }
}

if(! function_exists('category_form_child')){
    function category_form_child($childs, $fieldName){
        $str_child = '';
        if(count($childs)){
            $str_child .= '<ul style="list-style:none; margin: 0; padding: 0;">';
            foreach ($childs as $child){
                $str_child .= '<li>';
                $str_child .= '<div class="checkbox">
                                <label>'.
                                    form_checkbox($fieldName.'[]', $child['id'], set_checkbox($fieldName.'[]', $child['id'])).$child['caption'].
                                '</label>
                            </div>';
                $str_child .= '</li>' .PHP_EOL;
            }
            $str_child .= '</ul>'.PHP_EOL;
        }
        return $str_child;
    }
} 
 
 if(!function_exists('prepareList'))
 {
     function prepareList(array $items, $pid = 0)
     {
         $output = array();

        # loop through the items
        foreach ($items as $item) {

            # Whether the parent_id of the item matches the current $pid
            if ((int) $item['parent_id'] == $pid) {

                # Call the function recursively, use the item's id as the parent's id
                # The function returns the list of children or an empty array()
                if ($children = prepareList($items, $item['id'])) {

                    # Store all children of the current item
                    $item['children'] = $children;
                }

                # Fill the output
                $output[] = $item;
            }
        }

        return $output;
     }
 }
 
 if(!function_exists('get_list'))
 {
     function get_list($url, $lists, $child = FALSE, $child_id = FALSE)
     {
        $output = '';
         
        if (count($lists)>0) {
            $output .= ($child === false) ? '<ul class="dropdown-menu">' : '<ul class="dropdown-menu collapse" id="'.$url.'_'.$child_id.'">' ;

            foreach ($lists as $item) {
                $output .= '<li class="dropdown-right-onhover">';
                
                //check if there are any children
                if (isset($item['children']) && count($item['children'])) {
                    $output .= '<a href="'.site_url($url.'/'.$item['id']).'" data-toggle="collapse" class="dropdown-toggle collapsed" data-target="#'.$url.'_' . $item['id'] . '"><i class="fa fa-angle-double-right"></i>&nbsp;' . $item['caption'] . '</a>';
                    $output .= get_list($url, $item['children'], true, $item['id']);
                }
                else
                {
                    $output .= '<a href="'.site_url($url.'/'.$item['id']).'"><i class="fa fa-angle-double-right"></i>&nbsp;' . $item['caption'] . '</a>';
                }
                
                $output .= '</li>';
            }
            $output .= '</ul>';
        }
        return $output;
     }
 }
 
 if(!function_exists('get_list_mobile'))
 {
     function get_list_mobile($url, $lists, $child = FALSE, $child_id = FALSE)
     {
         $output = '';
         
        if (count($lists)>0) {
            $output .= ($child === false) ? '<ul class="dropdown-menu">' : '<ul class="dropdown-menu collapse" id="'.$url.'_'.$child_id.'">' ;

            foreach ($lists as $item) {
                $output .= '<li class="dropdown-right-onhover">';
                
                //check if there are any children
                if (isset($item['children']) && count($item['children'])) {
                    $output .= '<a href="javascript:void(0);" data-toggle="collapse" class="dropdown-toggle collapsed" data-target="#'.$url.'_' . $item['id'] . '"><i class="fa fa-angle-double-right"></i>&nbsp;' . $item['caption'] . '</a>';
                    $output .= get_list_mobile($url, $item['children'], true, $item['id']);
                }
                else
                {
                    $output .= '<a href="'.site_url($url.'/'.$item['id']).'"><i class="fa fa-angle-double-right"></i>&nbsp;' . $item['caption'] . '</a>';
                }
                
                $output .= '</li>';
            }
            $output .= '</ul>';
        }
        return $output;
     }
 }
 
 // get where in
if(!function_exists('get_where_in'))
{
    function get_where_in($items)
    {
        $array = array();
        if($items != FALSE)
        {
            foreach ($items as $item){
                $array[] = $item['id'];
                if(isset($item['children']) && count($item['children']))
                {
                    
                    foreach ($item['children'] as $item1)
                    {
                        $array[] = $item1['id'];
                        if (isset($item1['children']) && count($item1['children']))
                        {
                            foreach ($item1['children'] as $item2)
                            {
                                $array[] = $item2['id'];
                            }
                        }
                    }
                }
            }
        }
        else
        {
            return FALSE;
        }
        
        return $array;
    }
}

if(!function_exists('get_parent_slug'))
{
    function get_parent_slug($items, $search)
    {
        $parent = array();
        if($items == FALSE) return FALSE;
        foreach ($items as  $val)
        {
            if($val['id'] == $search){
                $parent[] = $val['id'].','.$val['caption'];
                if($val['parent_id'] != 0){
                    $parent[] = get_parent_slug($items, $val['parent_id']);
                }
            }       
        }
        
        return $parent;
    }
}


// prepare breadcrumb
if(!function_exists('prepare_breadcrumb'))
{
    function prepare_breadcrumb($url, $array)
    {
        $prepareBreadcrumb = array();
        $recur_flat_arr_obj =  new RecursiveIteratorIterator(new RecursiveArrayIterator($array));
        $flat_arr = iterator_to_array($recur_flat_arr_obj, false);
        foreach ($flat_arr as $item){
            $list = explode(',', $item);
            $id = $list[0];
            $caption = $list[1];
            $prepareBreadcrumb[$url.'/'.$id] = $caption;
        }
        
        return $prepareBreadcrumb;
    }
}

 // dropdown array
 if(!function_exists('get_dropdown'))
 {
    function get_dropdown($lists)
    {
        $output = array('' => '--- Select Category ---');
        foreach ($lists as $parent)
        {
            // parent
            $output[$parent['id']] = $parent['caption'];
            if (isset($parent['children']) && count($parent['children'])) 
            {
                foreach ($parent['children'] as $level1)
                {
                    // first level
                    $output[$level1['id']] = '- - - '.$level1['caption'];
                    if (isset($level1['children']) && count($level1['children'])) 
                    {
                        foreach ($level1['children'] as $level2)
                        {
                            // second level
                            $output[$level2['id']] = '- - - - - - '.$level2['caption'];
                            if (isset($level2['children']) && count($level2['children'])) 
                            {
                                foreach ($level2['children'] as $level3)
                                {
                                    // third level
                                    $output[$level3['id']] = '- - - - - - - - - '.$level3['caption'];
                                    if (isset($level3['children']) && count($level3['children'])) 
                                    {
                                        foreach ($level3['children'] as $level4)
                                        {
                                            // fourth level
                                            $output[$level4['id']] = '- - - - - - - - - - - - '.$level4['caption'];
                                            if (isset($level4['children']) && count($level4['children'])) 
                                            {
                                                foreach ($level4['children'] as $level5)
                                                {
                                                    // fifth level
                                                    $output[$level5['id']] = '- - - - - - - - - - - - - - - '.$level5['caption'];
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
        return $output;
    }
 }

 // member get list
 if(!function_exists('member_get_list'))
 {
     function member_get_list($url, $lists, $field = 'id')
     {
        $output = '';
         
        if (count($lists)>0) {
            $output .= '<ul class="dropdown-menu">' ;

            foreach ($lists as $item) {
                $output .= '<li>';
                $output .= '<a href="'.site_url($url.'/'.$item[$field]).'">'. $item['caption'] . '</a>';
                //check if there are any children
                
                $output .= '</li>';
            }
            $output .= '</ul>';
        }
        return $output;
     }
 }
 
/* End of file menu_helper.php */
/* Location: ./application/helpers/menu_helper.php */