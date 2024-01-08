$(document).ready(function () {
  showData(1);

  $("#student_SearchBar").on("keyup", function () {
    showData(1);
  });

  $(document).on("click", ".page-link", function () {
    var page = $(this).data("page");
    showData(page);
  });

  $(document).on('click','#saveStudentBtn',function(){
   var formData = $('#addStudentForm').serialize();
   addStudent(formData);
  });

  $(document).on('click','.viewData',function(){
    var id = $(this).val();
    viewData(id);
  });
  $(document).on('submit','#updateForm',function(e){
    e.preventDefault();
   var formData = new FormData(this);
    updateData(formData);
  });
  $(document).on('click','.editData',function(){
    var id = $(this).val();
   editData(id);
  });
  $(document).on('click','.deleteData',function(){
    var id = $(this).val();
    var url = baseurl+"/admin/getStudentData";
    $.ajax({
      url: url ,
      type: 'POST' ,
      data: {
      'id':id,
      'fetch':true
      },
      dataType: "json",
      success:function(res){
        if(res.Success){
          $('#deleteForm').find('#id').val(res.studentData['id']);
          $('#deleteForm').find('#email').text(res.studentData['email']);
        }
        else if(res.Failed){
    
        }
        else {
    
        }
      },
      error:function(){
        alert('error');
      }
    });
   
  });
  $(document).on('submit','#deleteForm',function(e){
    e.preventDefault();
    var formData = new FormData(this);
    
   deleteData(formData);
  });
  
});
function showData(page) {
  var search = $("#student_SearchBar").val();
  var url = baseurl +"/"+userType+"/studentList";
  $.ajax({
    url: url,
    type: "POST",
    dataType: "json",
    data: { page: page, search: search },
    success: function (response) {
      if (response) {
        if (response && response.studentData.length > 0) {
          var studentTable = "";

          // Loop through each student in the response
          $.each(response.studentData, function (index, student) {
            studentTable += "<tr>";
            studentTable += '<td class="hide">' + student.name + '</td>';
            studentTable += "<td>" + student.email + "</td>";
            studentTable +=
              "<td>" + student.grade_level.replace(/g/g, "") +' - '+ student.strand.toUpperCase()+' '+student.strand_class+ "</td>";
            studentTable +=
              '<td> <button type="button" class="btn btn-sm btn-info me-1 me-sm-2 text-white viewData" value="' +
              student.id +
              '" data-bs-toggle="modal" data-bs-target="#view"><span class="text-white fa-solid fa-eye"><span></button>';
            if (userType == "admin") {
              studentTable +=
                '<button type="button" class="btn btn-sm btn-success me-1 me-sm-2 editData" value="' +
                student.id +
                '" data-bs-toggle="modal" data-bs-target="#edit">' +
                '<span class="fa-solid fa-pen-to-square"></button>';
              studentTable +=
                '<button type="button" class="btn btn-sm btn-danger deleteData" value="' +
                student.id +
                '" data-bs-toggle="modal" data-bs-target="#delete"><i class="fa-solid fa-trash"></i></button>';
            }

            // Add more columns as needed
            studentTable += "</td></tr>";
            updatePagination(page, response.totalPages);
          });

          // Update the tbody with the new student data
        } else {
            
          studentTable += '<tr class="border-0 text-danger">';
          studentTable +=
            '<td colspan="8" class="st_no_s text-center">No student data found.</td></tr>';
        }
        $("#studentTb").html(studentTable);
        
       
      } else {
        alert("No response from database.");
      }
    },
    error: function () {
      alert("Failed to show student table.");
    },
  });
}
function updatePagination(currentPage, totalPages) {
    

    var paginationHtml = '';
    var linksPerPage = 6; 
   
    var startPage = Math.max(1, currentPage - Math.floor(linksPerPage / 2));
    var endPage = Math.min(totalPages, startPage + linksPerPage - 1);

    if (currentPage > 1) {
        paginationHtml += '<li class="page-item">' +
            '<a class="page-link" data-page="' + (currentPage - 1) + '" >Previous</a>' +
            '</li>';
    }
    for (var i = startPage; i <= endPage; i++) {
        paginationHtml += '<li class="page-item' + (i === currentPage ? ' active' : '') + '">' +
            '<a class="page-link" data-page="' + i + '" >' + i + '</a>' +
            '</li>';
    }
    if (currentPage < totalPages) {
        paginationHtml += '<li class="page-item">' +
            '<a class="page-link" data-page="' + (currentPage + 1) + '" >Next</a>' +
            '</li>';
    }
  $("#pagination").html(paginationHtml);
}
function addStudent(data){
  var url = baseurl+"/admin/addStudent";
  $.ajax({
    url: url,
    type: 'POST',
    data: {
      data,
      action:'add'
    } ,
    dataType: 'json',
    success: function(res){
      if(res.Success){
        showAlert('success',res.Message,"#addStudentForm #alertMessage");
        $('#addStudentForm')[0].reset();
      }
      else if(res.Failed){
    
        showAlert('danger',res.Message,"#addStudentForm #alertMessage");
      }
      else {
        alert("no response");
      }
    },
    error:function(xhr, status, error){
      // Handle Ajax request errors
      alert("An error occurred while communicating with the server.");
    }
  });
}

function editData(id) {
  var url = baseurl+"/admin/getStudentData";
$.ajax({
  url: url ,
  type: 'POST' ,
  data: {
    'id' : id,
    'fetch': true
  } ,
  dataType: "json",
  success:function(res){
    if(res.Success){
      $('#updateForm').find('#id').val(res.studentData['id']);
      $('#updateForm').find('#name').val(res.studentData['name']);
      $('#updateForm').find('#email').val(res.studentData['email']);
      $('#updateForm').find('#strand').val(res.studentData['strand']);
      $('#updateForm').find('#grade').val(res.studentData['grade_level']);
      $('#updateForm').find('#section').val(res.studentData['section']);
      $('#updateForm').find('#class').val(res.studentData['strand_class']);
    }
    else if(res.Failed){

    }
    else {

    }
  },
  error:function(){
    alert('error');
  }
});
}

function updateData(data) {
  var url = baseurl+"/admin/updateStudent";
$.ajax({
  url: url ,
  type: 'POST' ,
  data: {
    'id' : data.get('id'),
    'name' : data.get('name'),
    'email' : data.get('email'),
    'strand' : data.get('strand'),
    'grade' : data.get('grade'),
    'section' : data.get('section'),
    'class' : data.get('class'),
    'update': true
  },
  dataType: "json",
  success:function(res){
    if(res.Success){
      alert(res.Message);
      $('#edit').modal('hide');
      showData(1);
    }
    else if(res.Failed){

    }
    else {

    }
  },
  error:function(){
    alert('error');
  }
});
}

function viewData(id) {
  var url = baseurl+"/"+userType+"/getStudentData";
$.ajax({
  url: url ,
  type: 'POST' ,
  data: { 'id': id,'fetch':true},
  dataType: "json",
  success:function(res){
    if(res.Success){
      $('#view').find('#name').text(res.studentData['name']);
      $('#view').find('#email').text(res.studentData['email']);
      $('#view').find('#strand').text(res.studentData['grade_level']+' '+res.studentData['strand']+' '+res.studentData['strand_class']);
      $('#view').find('#id').text(res.studentData['id']);
      $('#view').find('#section').text(res.studentData['section']);
      $('#view').find('#unique_id').text(res.studentData['unique_id']);
      $('#view').find('#dateCreated').text(res.studentData['created_at']);
    }
    else if(res.Failed){
    
    }
    else {

    }
  },
  error:function(){
    alert('error');
  }
});
}

function deleteData(data) {
  var url = baseurl+"/admin/deleteStudent";
$.ajax({
    url: url ,
    type: 'POST' ,
    data: {
      'unique_id' : data.get('unique_id'),
      'id': data.get('id'),
      'delete' : true
    },
    dataType: "json",
    success:function(res){
      if(res.Success){
        alert(res.Message);
        $('#deleteForm')[0].reset();
        $('#delete').modal('hide');
       showData(1);
      }
      else if(res.Failed){
        alert(res.Message);
      }
      else {
        alert();
      }
    },
    error:function(){
      alert('error');
    }
  });
}


