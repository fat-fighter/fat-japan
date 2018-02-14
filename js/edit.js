var app = angular.module('app', []);
app.controller('formControl', function($scope) {
    $scope.data = {
        categories : [
            {value: "words", tag: "Word - Meaning"},
            {value: "phrases", tag: "Phrases"},
            {value: "verbs", tag: "Verbs"}
        ],
        selectedCategory : {value: "words", tag: "Word-Meaning"}
    };
    $scope.content = {Serial:0,WordId:"",Word:"",Category:"words",Tag:"",Meaning:"",Kanji:"",Uses:""};

    if (setId) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "db/content_controls.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.responseText);
                if (xhr.responseText == "false") {
                    alert("No entry exists with this id");

                    window.location = "edit.php";
                }
                $scope.wordContent = JSON.parse(xhr.responseText);
                $scope.data.selectedCategory = {
                    value: $scope.wordContent.Category,
                    tag: categoryTags[$scope.wordContent.Category]
                };
            }
        };

        xhr.send("operation=load&id=" + id);
    }
});
//
//
// var activeTextNode = null;
//
// function typeInTextarea(el, newText) {
//     var start = el.prop("selectionStart")
//     var end = el.prop("selectionEnd")
//     var text = el.val()
//     var before = text.substring(0, start)
//     var after  = text.substring(end, text.length)
//     el.val(before + newText + after)
//     el[0].selectionStart = el[0].selectionEnd = start + newText.length
//     el.focus()
// }
//
// $("button").on("click", function() {
//     typeInTextarea($("textarea"), "some text")
//     return false
// })
//
// function doc_keyUp(e) {
//
//     // this would test for whichever key is 40 and the ctrl key at the same time
//     if (e.ctrlKey && e.keyCode == 40) {
//         // call your function to do the thing
//         pauseSound();
//     }
// }
// document.addEventListener('keyup', shortcuts, false);