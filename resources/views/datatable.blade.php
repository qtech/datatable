<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Datatable</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
</head>
<body>  

    <input type="text" name="email" id="typedEmail" />
    <table id="datatable-example">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>



    <script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.15/lodash.min.js"></script>

    <script>
        $(document).ready(() => {
            const dt = $('#datatable-example').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "{{route('datatables')}}",
                    type: 'get',
                    data: function(d){
                        d.email = $('#typedEmail').val()
                    }
                },
                "columns":[
                    { "data":'id'},
                    { "data":'name'},
                    { "data":'email'},
                    { "data":'created_at'},
                    { "data": 'address'},
                    { "data": null}
                ],
                "columnDefs":[
                    {
                        targets:-1,
                        render: (a, e, t, n) => {
                            return `<button>Edit</button>`;
                        },
                    },
                    {
                        targets: 4,
                        render: (a, e, t, n) => {
                            console.log(t);
                            return 'this is my address for every column';
                        }
                    }
                ]
            });

            $('#typedEmail').on('keyup', _.debounce(() => {
                dt.ajax.reload();
            }, 500));
        });        
    </script>
</body>
</html>