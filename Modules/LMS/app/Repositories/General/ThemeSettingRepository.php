<?php

namespace Modules\LMS\Repositories\General;

use Illuminate\Http\Response;
use Modules\LMS\Models\General\ThemeSetting;
use Modules\LMS\Repositories\BaseRepository;

class ThemeSettingRepository extends BaseRepository
{
    protected static $model = ThemeSetting::class;

    protected static $exactSearchFields = [];

    /**
     *  updateOrCreate
     *
     * @param  mixed  $request
     * @return Response
     */
    public function updateOrCreate($request)
    {
        static::$model::updateOrCreate(
            ['key' => $request->key ?? ''],
            [
                'key' => $request->key,
                'content' => json_encode($request->except('_method', '_token', 'key')),
            ]
        );

        return response()->json(['status' => true, 'message' => translate('Change Successfully')]);
    }

    /**
     *  statusChange
     *
     * @param  int  $id
     * @return array
     */
    public function statusChange($id)
    {
        $language = parent::first($id);
        $language = $language['data'];
        $language->status = ! $language->status;
        $language->update();

        return ['status' => 'success', 'message' => translate('Status Change Successfully')];
    }
}
