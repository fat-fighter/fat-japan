<div class="main-content">

    <div class="title">
        CALENDAR
    </div>

    <div class="calendar" ng-controller="calendarControl">
        <div class="day" ng-repeat="day in days">
            <div class="date">{{ day.day }}</div>
            <div class="japanese">{{ day.japanese }}</div>
        </div>
        <div class="date" ng-repeat="date in dates">
            <div class="date">{{ date.date }}</div>
            <div class="japanese">{{ date.japanese }}</div>
        </div>
    </div>

    <div class="back">
        <a href="reference.php">Back to References</a>
    </div>

</div>

<script type="text/javascript">

    var app = angular.module('app', []);
    app.controller('calendarControl', function($scope) {
        $scope.days = [
            {day: "Sunday", japanese: "Nichiyōbi"},
            {day: "Monday", japanese: "Getsuyōbi"},
            {day: "Tuesday", japanese: "Kayōbi"},
            {day: "Wednesday", japanese: "Suiyōbi"},
            {day: "Thursday", japanese: "Mokuyōbi"},
            {day: "Friday", japanese: "Kinyōbi"},
            {day: "Saturday", japanese: "Dōyōbi"}
        ];
        $scope.dates = [
            {date: 1, japanese: "Tsuitachi"},
            {date: 2, japanese: "Futsuku"},
            {date: 3, japanese: "Mikka"},
            {date: 4, japanese: "Yokka"},
            {date: 5, japanese: "Itsuka"},
            {date: 6, japanese: "Muika"},
            {date: 7, japanese: "Nanoka"},
            {date: 8 , japanese: "Yo-ka"},
            {date: 9 , japanese: "Kokonoka"},
            {date: 10, japanese: "To-ka"},
            {date: 11, japanese: "Jū Ichi Nichi"},
            {date: 12, japanese: "Jū Ni Nichi"},
            {date: 13, japanese: "Jū San Nichi"},
            {date: 14, japanese: "Jū Yokka"},
            {date: 15, japanese: "Jū Go Nichi"},
            {date: 16, japanese: "Jū Roku Nichi"},
            {date: 17, japanese: "Jū Nana Nichi"},
            {date: 18, japanese: "Jū Hachi Nichi"},
            {date: 19, japanese: "Jū Ku Nichi"},
            {date: 20, japanese: "Hatsuka"},
            {date: 21, japanese: "Ni Jū Ichi Nichi"},
            {date: 22, japanese: "Ni Jū Ni Nichi"},
            {date: 23, japanese: "Ni Jū San Nichi"},
            {date: 24, japanese: "Ni Jū Yokka"},
            {date: 25, japanese: "Ni Jū Go Nichi"},
            {date: 26, japanese: "Ni Jū Roku Nichi"},
            {date: 27, japanese: "Ni Jū Nana Nichi"},
            {date: 28, japanese: "Ni Jū Hachi Nichi"},
            {date: 29, japanese: "Ni Jū Ku Nichi"},
            {date: 30, japanese: "San Jū Nichi"},
            {date: 31, japanese: "San Jū Ichi Nichi"}
            ];
    });

</script>

<link rel="stylesheet" href="css/calendar.css">