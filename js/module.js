
registerController("CommandController", ["$api", "$scope",function($api, $scope){

  $scope.csv_response = [];
  $scope.items = [];

  $scope.RunCommand = (function() {
    $api.request({
      module: "Alias",
      action: "RunCommand",
      Command_To_Run: $scope.selected
    },
  );
});


$scope.DelCommand = (function() {
  $api.request({
    module: "Alias",
    action: "DelCommand",
    Command_To_Delete: $scope.selected
  },
);
});


$scope.ListCommands = (function() {

  $api.request({
    module: "Alias",
    action: "ListCommands",
  }, function(response) {
    if (response.error === undefined) {
      $scope.csv_response = response;

      var start = 1;
      var start2 = 0;

      for(var i = 0; i < $scope.csv_response.length / 2; i++) {
        $scope.items.push({
          "value": $scope.csv_response[start], "text":$scope.csv_response[start2]

        });
        start += 2;
        start2 += 2;

      };
    }
  });
});


$scope.ListCommands();
$scope.selected = $scope.items;

}]);




registerController("SettingsController", ["$api", "$scope",function($api, $scope){

  $scope.command_name = "";
  $scope.command = "";
  $scope.command_message = "";


  $scope.SaveCommand = (function() {
    $api.request({

      module: "Alias",
      action: "SaveCommand",
      command_name: $scope.command_name,
      command: $scope.command,
      command_message: $scope.command_message

    }, function(response) {
      if (response.error === undefined) {

        $scope.command_message = response;
      } else {
        $scope.command_message = response.error;
      }

      command_name: $scope.command_name = "";
      command: $scope.command = "";

    });
  });


}]);
