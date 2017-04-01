angular.module("tableroApp")
    .filter("labelsFilter", function(){
        return function(label){
            var labelFiltered = label.split("_").join(" ");
            labelFiltered = labelFiltered.substr(0,1).toUpperCase() + labelFiltered.substr(1);
            return labelFiltered; 
        }
    });