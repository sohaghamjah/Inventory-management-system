<div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-borderless">
            <tr>
                <td><b>Customer Name</b></td>
                <td><b>:</b></td>
                <td>{{ $supplier -> name }}</td>
            </tr>
            <tr>
                <td><b>Company Name</b></td>
                <td><b>:</b></td>
                <td>{{ $supplier -> company_name }}</td>
            </tr>
            <tr>
                <td><b>Vat Number</b></td>
                <td><b>:</b></td>
                <td>{{ $supplier -> vat_number }}</td>
            </tr>
            <tr>
                <td><b>Email</b></td>
                <td><b>:</b></td>
                <td>{{ $supplier -> email }}</td>
            </tr>
            <tr>
                <td><b>Phone</b></td>
                <td><b>:</b></td>
                <td>{{ $supplier -> phone }}</td>
            </tr>
            <tr>
                <td><b>Address</b></td>
                <td><b>:</b></td>
                <td>{{ $supplier -> address }}</td>
            </tr>
            <tr>
                <td><b>Supllier City</b></td>
                <td><b>:</b></td>
                <td>{{ $supplier -> city }}</td>
            </tr>
            <tr>
                <td><b>Supllier State</b></td>
                <td><b>:</b></td>
                <td>{{ $supplier -> state }}</td>
            </tr>
            <tr>
                <td><b>Postal Code</b></td>
                <td><b>:</b></td>
                <td>{{ $supplier -> state }}</td>
            </tr>
            <tr>
                <td><b>Supllier Country</b></td>
                <td><b>:</b></td>
                <td>{{ $supplier -> country }}</td>
            </tr>
            <tr>
                <td><b>Created By</b></td>
                <td><b>:</b></td>
                <td>{{ $supplier -> created_by }}</td>
            </tr>
            <tr>
                <td><b>Modified By</b></td>
                <td><b>:</b></td>
                <td>{{ $supplier -> updated_by }}</td>
            </tr>
            <tr>
                <td><b>Status</b></td>
                <td><b>:</b></td>
                <td>{{ STATUS[$supplier -> status] }}</td>
            </tr>
            <tr>
                <td><b>Joining Date</b></td>
                <td><b>:</b></td>
                <td>{{ date('d M, Y', strtotime($supplier -> created_at)) }}</td>
            </tr>
            <tr>
                <td><b>Update Date</b></td>
                <td><b>:</b></td>
                <td>{{ date('d M, Y', strtotime($supplier -> updated_at)) }}</td>
            </tr>
        </table>
    </div>
</div>