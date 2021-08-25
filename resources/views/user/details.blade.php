<div class="col-md-12 text-center">
    @if ($user -> avatar)
        <img src="storage/{{ USER_AVATAR_PATH.$user->avatar }}" alt="{{ $user->name }}" style="width: 250px; height: 220px; text-center">
    @else
    <img src="images/{{ $user->gender == 1 ? 'male-persion' : 'female-persion' }}.jpg" alt="{{ $user->name }}" style="width: 250px; height: 220px; margin-bottom: 20px">
    @endif
</div>
<div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-borderless">
            <tr>
                <td><b>Name</b></td>
                <td><b>:</b></td>
                <td>{{ $user -> name }}</td>
            </tr>
            <tr>
                <td><b>Email</b></td>
                <td><b>:</b></td>
                <td>{{ $user -> email }}</td>
            </tr>
            <tr>
                <td><b>Mobile No</b></td>
                <td><b>:</b></td>
                <td>{{ $user -> mobile }}</td>
            </tr>
            <tr>
                <td><b>Gender</b></td>
                <td><b>:</b></td>
                <td>{{ GENDER[$user -> gender] }}</td>
            </tr>
            <tr>
                <td><b>Role</b></td>
                <td><b>:</b></td>
                <td>{{ $user -> role -> role_name }}</td>
            </tr>
            <tr>
                <td><b>Created By</b></td>
                <td><b>:</b></td>
                <td>{{ $user -> created_by }}</td>
            </tr>
            <tr>
                <td><b>Modified By</b></td>
                <td><b>:</b></td>
                <td>{{ $user -> modified_by }}</td>
            </tr>
            <tr>
                <td><b>Status</b></td>
                <td><b>:</b></td>
                <td>{{ STATUS[$user -> status] }}</td>
            </tr>
            <tr>
                <td><b>Joining Date</b></td>
                <td><b>:</b></td>
                <td>{{ date('d M, Y', strtotime($user -> created_at)) }}</td>
            </tr>
            <tr>
                <td><b>Update Date</b></td>
                <td><b>:</b></td>
                <td>{{ date('d M, Y', strtotime($user -> updated_at)) }}</td>
            </tr>
        </table>
    </div>
</div>