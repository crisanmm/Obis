<?php

    $conn = new mysqli('localhost', 'root', '', 'obis');
    if($conn->connect_errno != 0)
        exit("failed connection");
    $conn->begin_transaction();

    $datafile = fopen('brfss_filtered.csv', 'r');
    if(!$datafile)
        exit("failed fopen");

    $locations = [];
    $responses = [];
    $break_outs = [];
    $break_outs_category = [];
        
    // headers
    fgetcsv($datafile);

    $counter = 0;
        
    while(($line = fgetcsv($datafile)) !== false) {

        $year_value = $line[0];
        $locationabbr = $line[1];
        $location = $line[2];
        $response = $line[3];
        $break_out = $line[4];
        $break_out_category = $line[5];
        $sample_size = $line[6];
        $data_value = $line[7];
        $confidence_limit_low = $line[8];
        $confidence_limit_high = $line[9];
        $break_out_id = $line[10];
        $break_out_category_id = $line[11];
        $response_id = $line[12];
        
        // insert into bmi
        $stmt = $conn->prepare("INSERT INTO bmi(year_value, locationabbr, sample_size,
                            data_value_percentage, confidence_limit_low, confidence_limit_high,
                            response_id, break_out_id, break_out_category_id)
                            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isidddsss", $year_value, $locationabbr, $sample_size, $data_value,
                            $confidence_limit_low, $confidence_limit_high, $response_id,
                            $break_out_id, $break_out_category_id);
        if(!$stmt->execute())   
        exit("failed execute on \"insert into bmi\"");
        $stmt->close();

        // insert into locations if (key,value) pair hasn't been inserted yet
        if(!array_key_exists($locationabbr, $locations)) {
            $locations[$locationabbr] = $location;
            $stmt = $conn->prepare("INSERT INTO locations VALUES (?, ?)");
            $stmt->bind_param("ss", $locationabbr, $location);
            if(!$stmt->execute())
            exit("failed execute on \"insert into locations\"");
            $stmt->close();
            $counter++;
        }

        // insert into responses if (key,value) pair hasn't been inserted yet
        if(!array_key_exists($response_id, $responses)) {
            $responses[$response_id] = $response;
            $stmt = $conn->prepare("INSERT INTO responses VALUES (?, ?)");
            $stmt->bind_param("ss", $response_id, $response);
            if(!$stmt->execute())
                exit("failed execute on \"insert into responses\"");
            $stmt->close();
            $counter++;
        }

        // insert into break_outs if (key,value) pair hasn't been inserted yet
        if(!array_key_exists($break_out_id, $break_outs)) {
            $stmt = $conn->prepare("INSERT INTO break_outs VALUES(?, ?)");
            $stmt->bind_param("ss", $break_out_id, $break_out);
            if(!$stmt->execute())
                exit("failed execute on \"insert into break_outs\"");
            $stmt->close();
            $break_outs[$break_out_id] = $break_out;
            $counter++;
        }

        // insert into break_outs_category if (key,value) pair hasn't been inserted yet
        if(!array_key_exists($break_out_category_id, $break_outs_category)) {
            $break_outs_category[$break_out_category_id] = $break_out_category;
            $stmt = $conn->prepare("INSERT INTO break_outs_category VALUES(?, ?)");
            $stmt->bind_param("ss", $break_out_category_id, $break_out_category);
            if(!$stmt->execute())
                exit("failed execute on \"insert into break_outs_category\"");
            $stmt->close();
            $counter++;
        }

        $counter++;
    }

    echo "<pre>";
    echo "Inserted $counter rows.";
    echo "</pre>";

    $conn->commit();
    fclose($datafile);