<div class="col-md-12 text-center">
    @if ($employee->image)
        <img src="storage/{{ EMPLOYEE_IMAGE_PATH.$employee->image }}" alt="{{ $employee->name }}" style="width:60%;">
    @else
    <img src="images/male.svg" alt="{{ $employee->name }}" style="width:40%;">
    @endif
</div>
<div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-borderless">
            <tr>
                <td><b>Employee Name</b></td>
                <td><b>:</b></td>
                <td>{{ $employee -> name }}</td>
            </tr>
            <tr>
                <td><b>Department</b></td>
                <td><b>:</b></td>
                <td>{{ $employee -> department -> name }}</td>
            </tr>
            <tr>
                <td><b>Phone</b></td>
                <td><b>:</b></td>
                <td>{{ $employee -> phone }}</td>
            </tr>
            <tr>
                <td><b>City</b></td>
                <td><b>:</b></td>
                <td>{{ $employee -> city }}</td>
            </tr>
            <tr>
                <td><b>State</b></td>
                <td><b>:</b></td>
                <td>{{ $employee -> state }}</td>
            </tr>
            <tr>
                <td><b>Postal Code</b></td>
                <td><b>:</b></td>
                <td>{{ $employee -> postal_code }}</td>
            </tr>
            <tr>
                <td><b>Country</b></td>
                <td><b>:</b></td>
                <td>{{ $employee -> country }}</td>
            </tr>
            <tr>
                <td><b>Created By</b></td>
                <td><b>:</b></td>
                <td>{{ $employee -> created_by }}</td>
            </tr>
            <tr>
                <td><b>Modified By</b></td>
                <td><b>:</b></td>
                <td>{{ $employee -> updated_by }}</td>
            </tr>
            <tr>
                <td><b>Status</b></td>
                <td><b>:</b></td>
                <td>{{ STATUS[$employee -> status] }}</td>
            </tr>
            <tr>
                <td><b>Joining Date</b></td>
                <td><b>:</b></td>
                <td>{{ date('d M, Y', strtotime($employee -> created_at)) }}</td>
            </tr>
            <tr>
                <td><b>Update Date</b></td>
                <td><b>:</b></td>
                <td>{{ date('d M, Y', strtotime($employee -> updated_at)) }}</td>
            </tr>
        </table>
    </div>
</div>