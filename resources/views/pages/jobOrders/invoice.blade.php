<html>
<head>
    <title>
        print job order
    </title>
</head>
<body>
<center>
<div>
    File2PRINT<br/>
    <span style="font-size: 10px;">Vandam Mart Stall #15, Bulaon, City Of San Fernando, Pampanga</span>
    <br/>
        Globe #: 09166520817
    <br/>
        Smart #: 09218173000
    <br/>
    </span><br/>
    <center>
        <strong style="font-size: 35px;">{{str_pad($jobOrder, 5, '0', STR_PAD_LEFT)}}</strong><br/>
        <span>Sales Order Number</span>
        <br/><br/>

        <h4>Details</h4>
        <table cellspacing="5px">
            <tr>
                <td><strong>Created By</strong></td>
                <td>{{\App\User::find($profile->created_by)->username}}</td>
            </tr>
            <tr>
                <td><strong>Title</strong></td>
                <td>{{$profile->title}}</td>
            </tr>
            <tr>
                <td><strong>Amount</strong></td>
                <td>&#8369; {{number_format($profile->amount,2)}}</td>
            </tr>
            <tr>
                <td><strong>Down Payment</strong></td>
                <td>&#8369; {{number_format($profile->down_payment,2)}}</td>
            </tr>
            <tr>
                <td><strong>Balance</strong></td>
                <td>&#8369; {{number_format($profile->amount - $profile->down_payment,2)}}</td>
            </tr>
            <tr>
                <td><strong>Pick-up Date</strong></td>
                <td>{{date_format(date_create($profile->pickup_date),"d/M/Y")}}</td>
            </tr>
        </table>
        <br/><br/>
        <u style="font-size: 20px;">{{$profile->customer_name}}</u><br/>
        Customer Name
        <br/>
    </center>
    <br/>
    <div style="border-top: 2px dotted;border-color: #1c2529;">
        <br/>
        File2PRINT<br/>
        <span style="font-size: 10px;">Vandam Mart Stall #15, Bulaon, City Of San Fernando, Pampanga</span>
        <br/>
        Globe #: 09166520817
        <br/>
        Smart #: 09218173000
        <br/>
        </span><br/>
        <center>
            <strong style="font-size: 35px;">{{str_pad($jobOrder, 5, '0', STR_PAD_LEFT)}}</strong><br/>
            <span>Sales Order Number</span>
            <br/><br/>

            <h4>Details</h4>
            <table cellspacing="5px">
                <tr>
                    <td><strong>Created By</strong></td>
                    <td>{{\App\User::find($profile->created_by)->username}}</td>
                </tr>
                <tr>
                    <td><strong>Title</strong></td>
                    <td>{{$profile->title}}</td>
                </tr>
                <tr>
                    <td><strong>Amount</strong></td>
                    <td>&#8369; {{number_format($profile->amount,2)}}</td>
                </tr>
                <tr>
                    <td><strong>Down Payment</strong></td>
                    <td>&#8369; {{number_format($profile->down_payment,2)}}</td>
                </tr>
                <tr>
                    <td><strong>Balance</strong></td>
                    <td>&#8369; {{number_format($profile->amount - $profile->down_payment,2)}}</td>
                </tr>
                <tr>
                    <td><strong>Pick-up Date</strong></td>
                    <td>{{date_format(date_create($profile->pickup_date),"d/M/Y")}}</td>
                </tr>
            </table>
            <br/><br/>
            <u style="font-size: 20px;">{{$profile->customer_name}}</u><br/>
            Customer Name
            <br/>
        </center>
        <br/>
    </div>
    <div style="margin-top: 20px;border-top: 2px dotted;border-color: #1c2529;">
        <h4>Job Order Details</h4>
        <table cellspacing="5px">
            <tr>
                <td><strong>#</strong></td>
                <td>{{str_pad($profile->id, 5, '0', STR_PAD_LEFT)}}</td>
            </tr>
            <tr>
                <td><strong>Created By</strong></td>
                <td>{{\App\User::find($profile->created_by)->username}}</td>
            </tr>
            <tr>
                <td><strong>Title</strong></td>
                <td>{{$profile->title}}</td>
            </tr>
            <tr>
                <td><strong>Category</strong></td>
                <td>{{\App\category::find($profile->category_id)->name}}</td>
            </tr>
            <tr>
                <td><strong>Customer</strong></td>
                <td>{{$profile->customer_name}}</td>
            </tr>
            <tr>
                <td><strong>Contact #</strong></td>
                <td>{{$profile->customer_contact_number}}</td>
            </tr>
            <tr>
                <td><strong>Amount</strong></td>
                <td>&#8369; {{number_format($profile->amount,2)}}</td>
            </tr>
            <tr>
                <td><strong>Down Payment</strong></td>
                <td>&#8369; {{number_format($profile->down_payment,2)}}</td>
            </tr>
            <tr>
                <td><strong>Balance</strong></td>
                <td>&#8369; {{number_format($profile->amount - $profile->down_payment,2)}}</td>
            </tr>
            <tr>
                <td><strong>Pick-up Date</strong></td>
                <td>{{date_format(date_create($profile->pickup_date),"d/M/Y")}} {{$profile->pickup_time}}</td>
            </tr>
            <tr>
                <td colspan="2  "><strong>Description</strong></td>
            </tr>
            <tr>
                <td colspan="2"> {!! strip_tags(str_replace('<', ' <', $profile->description)) !!}</td>
            </tr>

        </table>
    </div>
    <br/><br/><br/>
    <div style="border-top: 2px dotted;border-color: #1c2529;"></div>
</div>
</center>
</body>

<script>
window.print();
</script>

</html>