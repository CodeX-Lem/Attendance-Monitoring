async function confirmation(e){
  e.preventDefault();
  const form = e.target.closest('form');
  try {
   const result = await Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    });

    
    if(result.isConfirmed){
      form.submit();
    }
  } catch (error) {
    Swal.fire(
      'Error!',
      'An error occurred while deleting the file.',
      'error'
    );
  }
}

