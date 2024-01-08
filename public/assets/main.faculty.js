$(document).ready(function(){
showData(1);

$("#faculty_SearchBar").on("keyup", function () {
    showData(1);
  });

  $(document).on("click", ".page-link", function () {
    var page = $(this).data("page");
    showData(page);
  });
  $(document).on('click','#saveFacultyBtn',function(){
    var formData = $('#addFacultyForm').serialize();
    addFaculty(formData);
  });
  $(document).on('submit','#deleteForm',function(e){
    e.preventDefault();
    var data = new FormData(this);
    deleteData(data);
  })
  $(document).on('click','.deleteModal',function(){
    var id = $(this).val();
    var url = baseurl+"/admin/getFacultyData";
    $.ajax({
      url: url ,
      type: 'POST' ,
      data: {id,'fetch':true} ,
      dataType: 'json',
      success:function(res){
        if(res.Success){
          $('#deleteForm').find('#id').val(res.facultyData['id']);
          $('#deleteForm').find('#email').text(res.facultyData['email']);
        }
        else if(res.Failed){

        }
        else {

        }
      },
      error:function(){

      }
    });
  });
  $(document).on('click','.editModal',function(){
    var id = $(this).val();
    editData(id)
  });
  $(document).on('click','.viewModal',function(){
    var id = $(this).val();
    viewData(id);
  });
  $(document).on('submit','#editForm',function(e){
    e.preventDefault();
    var data = new FormData(this);
    updateData(data);
  });
});

function showData(page){
    var search = $("#faculty_SearchBar").val();
    var url = baseurl + "/admin/facultyList";
    $.ajax({
      url: url,
      type: "POST",
      dataType: "json",
      data: { page: page, search: search },
      success: function (response) {
        if (response) {
          if (response && response.facultyData.length > 0) {
            var facultyTable = "";
  
            // Loop through each faculty in the response
            $.each(response.facultyData, function (index, faculty) {
              facultyTable += "<tr>";
              // facultyTable += '<td>'+faculty.id+'</td>';
              facultyTable += '<td>'+faculty.name+'</td>';
              facultyTable += '<td>'+faculty.email+'</td>';
              facultyTable += '<td>'+faculty.department+'</td>';
              facultyTable +=
                '<td> <button type="button" class="btn btn-sm btn-info me-1 me-sm-2 text-white viewModal" value="' +
                faculty.id +
                '" data-bs-toggle="modal" data-bs-target="#view"><span class="text-white fa-solid fa-eye"><span></button>';
                facultyTable +=
                  '<button type="button" class="btn btn-sm btn-success me-1 me-sm-2 editModal" value="' +
                  faculty.id +
                  '" data-bs-toggle="modal" data-bs-target="#edit">' +
                  '<span class="fa-solid fa-pen-to-square"></button>';
                facultyTable +=
                  '<button type="button" class="btn btn-sm btn-danger deleteModal" value="' +
                  faculty.id +
                  '" data-bs-toggle="modal" data-bs-target="#delete"><i class="fa-solid fa-trash"></i></button>';
  
              // Add more columns as needed
              facultyTable += "</td></tr>";

             
            });
  
            // Update the tbody with the new faculty data
          } else {
              
            facultyTable += '<tr class="border-0 text-danger">';
            facultyTable +=
              '<td colspan="8" class="st_no_s text-center">No faculty data found.</td></tr>';
          }

          $("#facultyTb").html(facultyTable);
          updatePagination(page, response.totalPages);
          
         
        } else {
          alert("No response from database.");
        }
      },
      error: function () {
        alert("Failed to show faculty table.");
      },
    });
}
function updatePagination(currentPage,totalPages){
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
function addFaculty(data){
  var url = baseurl+"/admin/addFaculty";

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
        $('#addFacultyForm')[0].reset();
        showAlert('success',res.Message,'#addFacultyForm #alertMessage');
      }
      else if(res.Failed){
        showAlert('danger',res.Message,'#addFacultyForm #alertMessage');
      }
      else {
        alert("no response");
      }
    },
    error:function(xhr, status, error){
      // Handle Ajax request errors
      console.error("Ajax request failed: " + error);
      alert("An error occurred while communicating with the server.");
    }
  });
}
function viewData(id){
var url = baseurl+"/admin/getFacultyData";
$.ajax({
  url: url ,
  type: 'POST' ,
  data: { 'id': id,'fetch':true},
  dataType: "json" ,
  success:function(res){
    if(res.Success){
    
      $('#view').find('#name').text(res.facultyData['name']);
      $('#view').find('#email').text(res.facultyData['email']);
      // $('#view').find('#department').text(result.facultyData['department']);
      $('#view').find('#id').text(res.facultyData['id']);
      $('#view').find('#unique_id').text(res.facultyData['unique_id']);
      $('#view').find('#dateCreated').text(res.facultyData['created_at']);
    }
    else if(res.Failed){
      alert(res.Message);
    }
    else {
      alert();
    }
  },
  error:function(){
    alert('failed to view');
  }
});
}
function deleteData(data){

  var id = data.get('id');
  var uniqueId = data.get('uniqueId');
  var url = baseurl+"/admin/deleteFaculty";
  $.ajax({
    url: url,
    type: 'POST',
    data: {
      'delete' : true,
      'id' : id,
      'unique_id' : uniqueId 
    } ,
    dataType: "json" ,
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
function editData(id){
var url = baseurl+"/admin/getFacultyData";

  $.ajax({
    url: url,
    type: 'POST',
    data: {
      'id' : id,
      'fetch': true
    } ,
    dataType: "json" ,
    success:function(res){
      if(res.Success){
        $('#editForm').find('#name').val(res.facultyData['name']);
        $('#editForm').find('#email').val(res.facultyData['email']);
        $('#editForm').find('#id').val(res.facultyData['id']);
      }
      else if(res.Failed){
        
      }else {

      }
    },
    error:function(){
      alert("error");
    }
    });
}
function updateData(data){
  var url = baseurl+"/admin/updateFaculty";
$.ajax({
  url: url,
  type: 'POST',
  data: {
    'id' : data.get('id'),
    'name' : data.get('name'),
    'email' : data.get('email'),
    'update': true
  } ,
  dataType: "json" ,
  success:function(res){
    if(res.Success){
      alert(res.Message);
      $('#edit').modal('hide');
      showData(1);
    }
  },
  error:function(){
    alert('error');
  }
})
}

