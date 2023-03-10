<div class="row">
    <div class="col-md-12">

        <div class="form-group">
            <label><strong>Justification for Vendor Selection :</strong></label>
            <textarea class="ckeditor form-control" name="justification_for_vendor_selection">
                 @if(isset($cs_Detail))
                    {!! $cs_Detail->justification_for_vendor_selection !!}
                @else
                @endif
            </textarea>
        </div>

    </div>
    <div class="col-md-6">
        @if(isset($cs_Detail) && $cs_Detail->getMedia())
            <h4> Previous Attachments </h4>
            @foreach($cs_Detail->getMedia() as $file)
                <p>{{ $file->file_name }} <a href="{{ $file->original_url }}" target="_blank">view </a></p>
            @endforeach
        @endif

        <h4 id="attachments_title">Attachments</h4>
        <div class="input-group input-files img_div form-group">
            <input type="file" name="files[]" class="form-control">
            <div class="input-group-btn">
                <a class="btn btn-icon btn-success btn-sm glow mr-1 mb-1 text-white cursor-pointer" id="add_input">
                    <i class="bx bx-plus-circle"></i>
                </a>
            </div>
        </div>
        <div class="clone hide" style="display: none;">
            <div class="input-files input-group form-group" style="margin-top:10px">
                <input type="file" name="files[]" class="form-control">
                <div class="input-group-btn">
                    <a class="btn btn-icon btn-danger btn-sm glow mr-1 mb-1 text-white cursor-pointer"
                       id="remove_input"> <i class="bx bx-trash-alt"></i></a>
                </div>
            </div>
        </div>
    </div>
    @if(isset($cs_Detail))
    <div class="col-md-6">

        <div class="card invoice-action-wrapper shadow-none">
            <div class="card-body">
                <div class="form-group">
                    <label for="description" class="d-block"> Comment </label>
                    <textarea name="description" rows="2"
                              class="w-100"></textarea>
                </div>
            </div>
        </div>
    </div>
        @endif
</div>

