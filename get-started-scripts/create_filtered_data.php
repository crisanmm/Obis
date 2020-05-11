<?php

    // column indexes
    // [0] => Year
    // [1] => Locationabbr
    // [2] => Locationdesc
    // [3] => Class
    // [4] => Topic
    // [5] => Question
    // [6] => Response
    // [7] => Break_Out
    // [8] => Break_Out_Category
    // [9] => Sample_Size
    // [10] => Data_value
    // [11] => Confidence_limit_Low
    // [12] => Confidence_limit_High
    // [13] => Display_order
    // [14] => Data_value_unit
    // [15] => Data_value_type
    // [16] => Data_Value_Footnote_Symbol
    // [17] => Data_Value_Footnote
    // [18] => DataSource
    // [19] => ClassId
    // [20] => TopicId
    // [21] => LocationID
    // [22] => BreakoutID
    // [23] => BreakOutCategoryID
    // [24] => QuestionID
    // [25] => ResponseID
    // [26] => GeoLocation

    $unfilteredFp = fopen('brfss.csv', 'r');
    if(!$unfilteredFp)
        exit("failed fopen('brfss.csv', 'r')");
        
    $filteredFp = fopen('brfss_filtered.csv', 'w');
    if(!$filteredFp)
        exit("failed fopen('brfss_unfiltered.csv', 'r')");

    $header = fgetcsv($unfilteredFp);

    // all columns have the same value (redundant data)
    unset($header[26]); // remove GeoLocation (one to one relationship between state and geolocation coordinates)
    unset($header[24]); // remove QuestionID
    unset($header[21]); // remove LocationID
    unset($header[20]); // remove TopicID
    unset($header[19]); // remove ClassID
    unset($header[18]); // remove DataSource
    unset($header[17]); // remove Data_Value_Footnote
    unset($header[16]); // remove Data_Value_Footnote_Symbol
    unset($header[15]); // remove Data_value_type
    unset($header[14]); // remove Data_value_unit
    unset($header[13]); // remove Display_order
    unset($header[5]); // remove Question
    unset($header[4]); // remove Topic
    unset($header[3]); // remove Class

    fputcsv($filteredFp, $header);
    
    $unfilteredCounter = 0;
    $filteredCounter = 0;
    
    while(($line = fgetcsv($unfilteredFp)) !== false) {

        $unfilteredCounter++;
        
        if(strtoupper($line[20]) == 'TOPIC09') {
            $filteredCounter++;
            
            unset($line[26]); // remove GeoLocation (one to one relationship between state and geolocation coordinates)
            unset($line[24]); // remove QuestionID
            unset($line[21]); // remove LocationID
            unset($line[20]); // remove TopicID
            unset($line[19]); // remove ClassID
            unset($line[18]); // remove DataSource
            unset($line[17]); // remove Data_Value_Footnote
            unset($line[16]); // remove Data_Value_Footnote_Symbol
            unset($line[15]); // remove Data_value_type
            unset($line[14]); // remove Data_value_unit
            unset($line[13]); // remove Display_order
            unset($line[5]); // remove Question
            unset($line[4]); // remove Topic
            unset($line[3]); // remove Class
            fputcsv($filteredFp, $line);
        }
        
    }

    echo "Unfiltered rows : $unfilteredCounter";
    echo "<br />";
    echo "Filtered rows : $filteredCounter";
    
    fclose($unfilteredFp);
    fclose($filteredFp);