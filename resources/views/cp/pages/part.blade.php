<div data-id="{{ $post_id }}" class="tab-pane tabstatic-page tabpanel-page {{ isset($active)?"active":"" }}"
     id="{{$id }}" role="tabpanel">
    <div class="form-group">
        <label>{{$titleValue }}</label>
        @foreach($languages as $language)
            <div data-lang="{{$language->iso_code}}"
                 class="input-wlbl switchable {{$language->iso_code !==$locale ?"hidden":""}}">
                <div>
                    <textarea id="{{$detailsName }}_{{strtolower($language->iso_code)}}"
                              name="{{$detailsName }}[{{strtolower($language->iso_code)}}]"
                              rows="10"
                              style="height: 500px;"
                              class="form-control
                              input-lang {{$language->is_rtl ?'tinymce-rtl'
                              :'tinymce'}}">{!! $details->{$language->iso_code}??'' !!}</textarea>
                </div>
            </div>
        @endforeach


    </div>
</div>

