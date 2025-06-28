<x-dashboard-layout>
    <x-slot:title>{{ isset($role) ? translate('Edit') : translate('Create') }} {{ translate('Role') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="{{ isset($role) ? 'Edit' : 'Create' }} Role" page-to="Role"
        back-url="{{ route('role.index') }}" />
    <form action="{{ isset($role) ? route('role.update', $role->id) : route('role.store') }}" method="post"
        class="form">
        @csrf
        @if (isset($role))
            @method('PUT')
        @endif
        <div class="grid grid-cols-12 gap-x-4 card">
            <div class="col-span-full md:col-span-6">
                <div class="leading-none">
                    <label for="title" class="form-label"> {{ translate('Name') }} <span
                            class="require-field"><b>*</b></span></label>
                    <input type="text" id="title" name="name" value="{{ $role->name ?? '' }}"
                        class="form-input">
                    <span class="text-danger error-text name_err"></span>
                </div>

                <input type="hidden" name="guard_name" value="admin" class="form-input">
                <div class="leading-none mt-6">
                    <label class="form-label"> {{ translate('Permission') }}</label>
                    <select name="permissions[]" class="permission-list" multiple>
                        @foreach (get_all_permission() as $key => $permission)
                            <optgroup label="{{ $key }}">
                                @foreach ($permission as $item)
                                    <option value="{{ $item->name }}"
                                        @if (isset($role->permissions)) @foreach ($role->permissions as $rolePermission)
                                                {{ $item->name == $rolePermission->name ? 'selected' : '' }}   
                                            @endforeach @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card flex justify-end">
            <button type="submit" class="btn b-solid btn-primary-solid dk-theme-card-square">
                {{ isset($role) ? translate('Update') : translate('Save') }}
            </button>
        </div>
    </form>
</x-dashboard-layout>
