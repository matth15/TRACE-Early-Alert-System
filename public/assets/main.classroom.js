$(document).ready(function () {
  showClassroom();

  showSubClassroom();

  $(document).on("click", "#joinClassBtn", function () {
    var code = $("#nav-otherclass").find("#search").val();
    invitationCode(code);
  });
  $(document).on("click", "#joinMainClassBtn", function () {
    alert();
  });

  $(document).on("submit", "#create", function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    create(formData);
  });
});

function invitationCode(code) {
  var url = baseurl + "/classroom/join";
  $.ajax({
    url: url,
    type: "POST",
    data: {
      join: true,
      code: code,
    },
    dataType: "json",
    success: function (res) {
      if (res.Success) {
        showAlert('success',res.Message,'#nav-otherclass #alertMessage');
      } else if (res.Failed) {
        showAlert('danger',res.Message,'#nav-otherclass #alertMessage');
      }
    },
    error: function () {
      alert("error");
    },
  });
}

function showSubClassroom() {
  var url = baseurl + "/classroom/show";

  $.ajax({
    url: url,
    type: "POST",
    data: { showsub: true },
    dataType: "json",
    success: function (res) {
      if (res.Success) {
        var mainClass = "";
        $.each(res.Classroom, function (index, Classroom) {
          mainClass =
            '<div class="col col-xxl-4 col-xl-6 col-md-7 col-sm-8 p-3">' +
            '<div class="card"> <div class="card-body shadow-sm">' +
            '<div class="card-content">' +
            '<h5 class="card-title d-none d-sm-block" id="section">' +
            Classroom["unique_id"] +
            " - " +
            Classroom["section"] +
            "</h5>" +
            '<h6 class="card-subtitle" id="grade_strand">' +
            Classroom["grade"] +
            " " +
            Classroom["strand"] +
            " " +
            Classroom["class"] +
            "</h6>" +
            '<p class="text-white d-flex justify-content-end m-0 px-2 pt-2 pb-1" id="teacher">'+res.Teachers[index]+'</p></div> <hr>' +
            ' <a href="' +
            baseurl +
            "/classroom/main/" +
            Classroom["unique_id"] +
            '" class="stretched-link"><h5>Open</h5></a></div></div></div>';

          $("#nav-otherclass #main").append(mainClass);
        });
      } else if (res.Failed) {
        var mainClass = "";
        mainClass +=
          '<div class="col-12><div class="container-fluid"<div class="row"<div class="col">' +
          '<h5  class="p-4" id="no-classroom-found">' +
          res.Message +
          "</h5>" +
          "</div></div></div></div>";

        $("#nav-otherclass #main").html(mainClass);
      }
    },
    error: function () {
      alert("error to show sub class");
    },
  });
}
function showClassroom() {
  var url = baseurl + "/classroom/show";

  $.ajax({
    url: url,
    type: "POST",
    data: { show: true },
    dataType: "json",
    success: function (res) {
      if (res.Success) {
        var mainClass = "";
        mainClass +=
        '<div class="col col-xxl-4 col-xl-6 col-md-7 col-sm-8"><div class="card">'+
            '<div class="card-body shadow-sm"><div class="card-content">'+
                    '<h5 class="card-title " id="section">'+res.Classroom['unique_id']+' - '+res.Classroom['section']+'</h5>'+
                    '<div class="dropdown menu-btn" id="menuBtn">'+
                        '<a class="text-white " href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">'+
                        '<i class="fa-solid fa-ellipsis-vertical"></i></a>'+
                        '<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
                        if(res.userType == 'student'){
                            mainClass += '<li><button class="dropdown-item" type="button"><i class="fa-solid fa-right-from-bracket me-2"></i>Leave</button></li>';
                        }
                        else if(res.userType == 'teacher'){
                            mainClass += '<li><button class="dropdown-item" type="button">Abandon</button></li>';
                           }
                       mainClass += '</ul></div><h6 class="card-subtitle" id="grade_strand">'+res.Classroom['grade']+' '+res.Classroom['strand']+' '+res.Classroom['class']+'</h6>'+
                    '<p class="text-white d-flex justify-content-end m-0 px-2 pt-2 pb-1" id="teacher">'+res.Classroom['teacher']+'</p>'+
                '</div><hr><div style ="transform: rotate(0);">'+
                '<a href="http://localhost:3000/classroom/main/'+res.Classroom['unique_id']+'" class="stretched-link">'+
                    '<h5>Open</h5></a></div></div></div></div>';

        $("#nav-classroom .row").append(mainClass);
      } else if (res.Failed) {
        var mainClass = "";
        mainClass +=
          '<div class="col-12><div class="container-fluid"<div class="row"<div class="col">' +
          '<h5  class="p-4" id="no-classroom-found">' +
          res.Message +
          "</h5>" +
          "</div></div></div></div>";

        $("#nav-classroom .row").append(mainClass);
      }
    },
    error: function () {
      alert("error to show");
    },
  });
}

function create(data) {
  var url = baseurl + "/classroom/create";
  $.ajax({
    url: url,
    type: "POST",
    data: {
      create: true,
      section: data.get("section"),
      strand: data.get("strand"),
      class: data.get("class"),
      grade: data.get("grade"),
    },
    dataType: "json",
    success: function (res) {
      if (res.Success) {
        $("#create")[0].reset();
        showAlert('success',res.Message,"#create #alertMessage");
      } else if (res.Failed) {
        showAlert('danger',res.Message,"#create #alertMessage");
      }
    },
    error: function () {
      alert("error");
    },
  });
}
