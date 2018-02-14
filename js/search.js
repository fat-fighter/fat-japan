var app = angular.module('app', []);
app.controller('loadControl', function($scope) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "db/content_controls.php", false);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            $scope.dictionary = JSON.parse(xhr.responseText);
            document.getElementById("search-section").style.opacity = 1;
            document.getElementById("loader").style.opacity = 0;
            document.getElementById("loader").style.height = 0;
        }
    };

    xhr.send(loadQuery);
});

if (!searchQuery) {

    app.controller('pageControl', function($scope) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "db/content_controls.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            console.log(xhr.responseText);
            if (xhr.readyState == 4 && xhr.status == 200) {
                var l = (currentPage > 3) ? (currentPage - 3) : 1;
                var t = Math.ceil(parseInt(xhr.responseText) / searchLimit);

                if ((currentPage > t && t > 0) || currentPage < 1) {
                    window.location = "search.php?type=1&category=" + categories;
                }

                var r = (currentPage < t-3) ? (currentPage + 3) : t;
                    $scope.pages = (Array.from((new Array(r-l+1)).keys())).map(function(x) { return x+l; });

                $scope.isDisabled = {"prev" : false, "next": false, "first" : false, "last" : false};
                if (currentPage <= 1) {
                    $scope.isDisabled.prev = true;
                    $scope.isDisabled.first = true;
                }
                if (currentPage >= t) {
                    $scope.isDisabled.next = true;
                    $scope.isDisabled.last = true;
                }

                $scope.limit = searchLimit;
                $scope.current = currentPage;
                $scope.last = t;
            }
        };

        xhr.send("operation=count&category=" + categories);
    });

}

function deleteWord(elem) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "db/content_controls.php", false);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 400) {
            console.log(xhr.responseText);
        }
    };

    xhr.send("operation=delete&wordId=" + elem.getAttributeNode("del-id").value);
}