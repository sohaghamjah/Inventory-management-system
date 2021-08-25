<div class="modal fade show" id="store_or_update_modal" tabindex="-1" role="dialog" aria-labelledby="model-1" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">

      <!-- Modal Content -->
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header bg-primary text-white">
          <h3 class="modal-title text-white" id="model-1"></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">×</span>
          </button>
        </div>
        <!-- /modal header -->

        <!-- Modal Body -->
        <form action="" id="store_or_update_form">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <x-forms.selectbox labelName="Module" name="module_id" required="required" col="col-md-12" class="selectpicker">
                        @if (!empty($data['modules']))
                            @foreach ($data['modules'] as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        @endif
                    </x-forms.selectbox>
                    <div class="col-md-12">
                        <table id="permission_table" class="table table-borderless">
                            <thead class="bg-primary">
                                <tr>
                                    <th width="45%">Permission Name</th>
                                    <th width="45%">Permission Slug</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="text" name="permission[1][name]" id="permission_1_name" class="form-control" onkeyup="urlGenerator(this.value,'permission_1_slug')" placeholder="Enter Permission Name...">
                                    </td>
                                    <td>
                                        <input type="text" name="permission[1][slug]" id="permission_1_slug" class="form-control" placeholder="Enter Permission Slug...">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" id="add_permission" data-toggle="tooptip" data-placement="top" data-original-title="Add Permission Field"><i class="fas fa-plus-square"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /modal body -->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" style="padding: 9px 30px" id="save_btn"></button>
            </div>
        </form>
        <!-- /modal footer -->

      </div>
      <!-- /modal content -->

    </div>
  </div>
