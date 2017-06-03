<?php namespace pineapple;

  $GLOBALS["CSV_File"] = "/sd/modules/Alias/includes/Saved_Commands.csv";
  $GLOBALS["CSV_Delete_Script"] = "python /sd/modules/Alias/includes/csvDel.py ";


class Alias extends Module
{
      public function route(){


        switch ($this->request->action) {

          case "ListCommands":
            $this->ListCommands();
            break;

          case "SaveCommand":
              $this->SaveCommand();
              break;

          case "RunCommand":
              $this->RunCommand();
              break;

          case "DelCommand":
          $this->DeleteCommand();
            break;

        }
    }




    private function ListCommands()
    {

      $send =  array();
      $row = 1;

      if (($handle = fopen($GLOBALS["CSV_File"], "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);

      $row++;
        for ($c=0; $c < $num; $c++) {
          array_push($send,$data[$c]);
        }

    }
    fclose($handle);
    $this->response = $send;
      }
    }




    private function RunCommand()
    {

      exec("{$this->request->Command_To_Run} > /dev/null 2>/dev/null &");

    }




    private function DeleteCommand()
    {

      exec("{$GLOBALS["CSV_Delete_Script"]} '{$this->request->Command_To_Delete}' > /dev/null 2>/dev/null &");

    }




    private function SaveCommand()
    {


      $Error_msg_name = "Please enter a name for the command.";
      $Error_msg_cmd = "Please enter a command.";
      $Other_error_msg = "There was an error";
      $Success_msg = "Command Saved.";



        if (empty($this->request->command_name)) {
            $this->error = $Error_msg_name;
        }
          elseif (empty($this->request->command)) {
          $this->error = $Error_msg_cmd;
        }

        else {

            $command_csv = fopen($GLOBALS["CSV_File"], 'a');

            $input_list = array (
                array(),
            );

            foreach ($input_list as $fields) {
              array_push($fields, $this->request->command_name, $this->request->command);
              fputcsv($command_csv, $fields);
            }

            fclose($command_csv);
            foreach ($input_list as $fields) {
              unset($fields);
            }

            if ($returnCode !== false) {
                $this->response = $Success_msg;
            }
                else {
                $this->error = $Other_error_msg;

            }
        }
    }
}
