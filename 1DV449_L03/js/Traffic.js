/**
 * Created by Jonas on 2014-12-11.
 */
var userChoice;
var listOfTraficInfo = [];
var markers = [];


//Initerar traffic.js
function init()
{
    getMessages();
    getCategory();
}

//JQUERYs lösning på "onclick". Lyssnar efter "SelectList" från echoHTML.php.
function getCategory()
{
    $("#SelectList").change(function(v)
    {
        deleteMarker();
        $("#box").empty();
        userChoice = v.target.value;
        filterTraficEvents(userChoice);
    })
}

//Tar hand om användarens val i drop-down-listan och filtrerar sedan efter önskemål.
function filterTraficEvents(userChoice) {
    if (userChoice == "4")
    {
        listOfTraficInfo.forEach(function (DisplayAll)
        {
            displayMessage(DisplayAll.title);
            setMarker(DisplayAll.latitude, DisplayAll.longitude)
        })
    }
    else
    {
        listOfTraficInfo.filter(function (filteredData) {
            if (filteredData.category == userChoice) {
                displayMessage(filteredData.title);
                setMarker(filteredData.latitude, filteredData.longitude)
            }
        })
    }
}

/*Här hämtar vi ut trafikinformationen från SR*/
function getMessages()
{
    var category;
    $.ajax
    (
        {
            type: "get",
            url: "getTrafficInfo.php",
            success: function(data)
            {
                data = JSON.parse(data);

                for(var i = 0; i < data["messages"].length; i++)
                {
                    addToArray(data["messages"][i]);
                    setMarker(data["messages"][i].latitude, data["messages"][i].longitude);
                }
            }
        }
    )
}

function addToArray(message)
{
    console.log(message);
    listOfTraficInfo.push(message);
    displayMessage(message.title);
}

function displayMessage(title)
{
    var box = document.getElementById("box");
    var li = document.createElement("li");
    var aTag = document.createElement("a");

    aTag.textContent = title;
    li.appendChild(aTag);
    box.appendChild(li);
}


function setMarker(latitude, longitude)
{

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(latitude, longitude),
        map: Map.map,
        title:"Hello World!"
    });
    markers.push(marker);
}

function deleteMarker()
{
    markers.forEach(function (deleteAllMarkers)
    {
        deleteAllMarkers.setMap(null);
    })
}
window.addEventListener("load", init());