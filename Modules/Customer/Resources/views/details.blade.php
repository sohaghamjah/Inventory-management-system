<div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-borderless">
            <tr>
                <td><b>Customer Group</b></td>
                <td><b>:</b></td>
                <td>{{ $customer -> customerGroup -> group_name }}</td>
            </tr>
            <tr>
                <td><b>Customer Name</b></td>
                <td><b>:</b></td>
                <td>{{ $customer -> name }}</td>
            </tr>
            <tr>
                <td><b>Company Name</b></td>
                <td><b>:</b></td>
                <td>{{ $customer -> company_name }}</td>
            </tr>
            <tr>
                <td><b>Tax Number</b></td>
                <td><b>:</b></td>
                <td>{{ $customer -> tax_number }}</td>
            </tr>
            <tr>
                <td><b>Email</b></td>
                <td><b>:</b></td>
                <td>{{ $customer -> email }}</td>
            </tr>
            <tr>
                <td><b>Phone</b></td>
                <td><b>:</b></td>
                <td>{{ $customer -> phone }}</td>
            </tr>
            <tr>
                <td><b>Address</b></td>
                <td><b>:</b></td>
                <td>{{ $customer -> address }}</td>
            </tr>
            <tr>
                <td><b>Supllier City</b></td>
                <td><b>:</b></td>
                <td>{{ $customer -> city }}</td>
            </tr>
            <tr>
                <td><b>Supllier State</b></td>
                <td><b>:</b></td>
                <td>{{ $customer -> state }}</td>
            </tr>
            <tr>
                <td><b>Postal Code</b></td>
                <td><b>:</b></td>
                <td>{{ $customer -> state }}</td>
            </tr>
            <tr>
                <td><b>Supllier Country</b></td>
                <td><b>:</b></td>
                <td>{{ $customer -> country }}</td>
            </tr>
            <tr>
                <td><b>Created By</b></td>
                <td><b>:</b></td>
                <td>{{ $customer -> created_by }}</td>
            </tr>
            <tr>
                <td><b>Modified By</b></td>
                <td><b>:</b></td>
                <td>{{ $customer -> updated_by }}</td>
            </tr>
            <tr>
                <td><b>Status</b></td>
                <td><b>:</b></td>
                <td>{{ STATUS[$customer -> status] }}</td>
            </tr>
            <tr>
                <td><b>Joining Date</b></td>
                <td><b>:</b></td>
                <td>{{ date('d M, Y', strtotime($customer -> created_at)) }}</td>
            </tr>
            <tr>
                <td><b>Update Date</b></td>
                <td><b>:</b></td>
                <td>{{ date('d M, Y', strtotime($customer -> updated_at)) }}</td>
            </tr>
        </table>
    </div>
</div>