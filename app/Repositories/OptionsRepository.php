<?php

namespace App\Repositories;

use App\Models\Options;
use App\Models\Options as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpParser\Node\Expr\AssignOp\Concat;

/**
 * Class ArticleRepository
 *
 * @package App\Repositories
 */
class OptionsRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @return array
     */
    public function getMainOptions()
    {
        $options['schedule'] = $this->model::where('name', 'schedule')->select('value')->first();
        $options['email'] = $this->model::where('name', 'email')->select('value')->first();
        $options['phone'] = $this->model::where('name', 'phone')->select('value')->first();
        $options['facebook'] = $this->model::where('name', 'facebook')->select('value')->first();
        $options['instagram'] = $this->model::where('name', 'instagram')->select('value')->first();
        $options['telegram'] = $this->model::where('name', 'telegram')->select('value')->first();
        $options['viber'] = $this->model::where('name', 'viber')->select('value')->first();
        $options['whatsapp'] = $this->model::where('name', 'whatsapp')->select('value')->first();
        $options['fb_messenger'] = $this->model::where('name', 'fb_messenger')->select('value')->first();

        return $options;
    }


    public function updateMainOptions($data)
    {
        $this->model::where('name', 'schedule')->update(['value' => $data['schedule']]);
        $this->model::where('name', 'email')->update(['value' => $data['email']]);
        $this->model::where('name', 'phone')->update(['value' => $data['phone']]);
        $this->model::where('name', 'facebook')->update(['value' => $data['facebook']]);
        $this->model::where('name', 'instagram')->update(['value' => $data['instagram']]);
        $this->model::where('name', 'telegram')->update(['value' => $data['telegram']]);
        $this->model::where('name', 'viber')->update(['value' => $data['viber']]);
        $this->model::where('name', 'whatsapp')->update(['value' => $data['whatsapp']]);
        $this->model::where('name', 'fb_messenger')->update(['value' => $data['fb_messenger']]);

        return true;
    }

    /**
     * @return array
     */
    public function getScriptsOptions()
    {
        $options['head_scripts'] = $this->model::where('name', 'head_scripts')->select('value')->first();
        $options['after_body_scripts'] = $this->model::where('name', 'after_body_scripts')->select('value')->first();
        $options['footer_scripts'] = $this->model::where('name', 'footer_scripts')->select('value')->first();

        return $options;
    }


    public function updateScriptsOptions($data)
    {
        $this->model::where('name', 'head_scripts')->update(['value' => $data['head_scripts']]);
        $this->model::where('name', 'after_body_scripts')->update(['value' => $data['after_body_scripts']]);
        $this->model::where('name', 'footer_scripts')->update(['value' => $data['footer_scripts']]);

        return true;
    }

    public function getToProd()
    {
        return $this->getMainOptions() + $this->getScriptsOptions();
    }
}
