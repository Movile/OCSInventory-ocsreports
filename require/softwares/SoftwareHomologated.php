<?php

class SoftwareHomologated
{


    public function get_all_not_homologated(){
        $sql_not_homol_soft = "select s.HARDWARE_ID as HARDWARE_ID, s.ID as ID from software as s left join software_homologated as sh on s.ID=sh.SOFTWARE_ID where sh.ID is NULL;";
        $result_not_homol_soft = mysqli_query($_SESSION['OCS']["readServer"], $sql_not_homol_soft);
        $i = 0;
        while ($item_not_homol_soft = mysqli_fetch_array($result_not_homol_soft)) {
            $not_homol_soft[$i] = array(
                'ID' => $item_not_homol_soft['ID'],
                'HARDWARE_ID' => $item_not_homol_soft['HARDWARE_ID']
            );
            $i++;
        }
        return $not_homol_soft;
    }

    /**
     * Insert new category
     * @param string $catName
     * @return boolean
     */
    public function create_occurrences($bad_boys_list){

        $grouped_bad_boys = array_reduce($bad_boys_list, function($carry, $item) {
            if(!isset($carry[$item['HARDWARE_ID']])){
                $carry[$item['HARDWARE_ID']] = array();
            }
            $carry[$item['HARDWARE_ID']] += [$item['ID']]; 
            return $carry;
        }, array());


        foreach ($grouped_bad_boys as $key => $value) {
            //I'm not taking care for injections here
            
            $all_soft = array();

            $get_new = "SELECT `GENERIC_FIELD` FROM `occurence` where `OCCURRENCES_CATEGORY_ID` = 1 AND `HARDWARE_ID` = `".$key."` AND `TIMESTAMP` > CURRENT_TIMESTAMP() - 86400 AND `GENERIC_FIELD` NOT IN ARRAY([";
            foreach ($value as $software_id){
                $get_new .= "`".$software_id."`,";
                $all_soft += [$software_id];
            }
            $get_new = rtrim($get_new, ",");
            $get_new .= "])";
            $result = mysqli_query($_SESSION['OCS']["readServer"], $get_new);

            $existing_occurrences = array();

            while ($item_not_homol_soft = mysqli_fetch_array($result)) {
                $existing_occurrences += [item_not_homol_soft['GENERIC_ID']];
            }


            $new_occurrences = array_diff($all_soft, $existing_occurrences);
            $sql = "INSERT INTO `occurrence` (`HARDWARE_ID`, `GENERIC_FIELD`, `OCCURRENCES_CATEGORY_ID`, `TIMESTAMP`) values ";

            foreach($new_occurrences as $new_occurrence) {
                $sql .= "(".$key.",'".$new_occurrence."',1,NOW()),";
            }

            while ($item_not_homol_soft = mysqli_fetch_array($result_not_homol_soft)) {
                $sql = rtrim($sql, ",");
                $sql .= ';';
                mysqli_query($_SESSION['OCS']["writeServer"], $sql);
            }

        }
        
    }


}