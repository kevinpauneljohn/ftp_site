<html>
<head>
    <title>
        print job order
    </title>
</head>
<body>
<div>
    <center>
        <h2>{{str_pad($jobOrder, 5, '0', STR_PAD_LEFT)}}</h2>
        <span>Job Order Number</span>
        <br/>
        ______________________
        <br/>
        Signature
    </center>
    <div style="margin-top: 20px;border-top: 2px dotted;border-color: #1c2529;">
        <center>
            <h2>{{str_pad($jobOrder, 5, '0', STR_PAD_LEFT)}}</h2>
            <span>Job Order Number</span>
        </center>
    </div>
    <div style="margin-top: 20px;border-top: 2px dotted;border-color: #1c2529;">
        <h4>Job Order Details</h4>
        <table>
            <tr>
                <td><strong>#</strong></td>
                <td>: {{str_pad($profile->id, 5, '0', STR_PAD_LEFT)}}</td>
            </tr>
            <tr>
                <td><strong>Title</strong></td>
                <td>: {{$profile->title}}</td>
            </tr>
            <tr>
                <td><strong>Category</strong></td>
                <td>: {{\App\category::find($profile->category_id)->name}}</td>
            </tr>
            <tr>
                <td><strong>Customer</strong></td>
                <td>: {{$profile->customer_name}}</td>
            </tr>
            <tr>
                <td><strong>Contact #</strong></td>
                <td>: {{$profile->customer_contact_number}}</td>
            </tr>
            <tr>
                <td><strong>Pick-up date</strong></td>
                <td>: {{$profile->pickup_date}} | {{$profile->pickup_time}}</td>
            </tr>
            <tr>
                <td colspan="2  "><strong>Description</strong></td>
            </tr>
            <tr>
                <td colspan="2"> {!! strip_tags(str_replace('<', ' <', $profile->description)) !!}</td>
            </tr>
        </table>
    </div>
</div>
</body>

<script>
window.print();
</script>

</html>