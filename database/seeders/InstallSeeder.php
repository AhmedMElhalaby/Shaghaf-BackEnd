<?php
namespace Database\Seeders;

use App\Helpers\Constant;
use App\Models\Admin;
use App\Models\ModelPermission;
use App\Models\ModelRole;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class InstallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Admin = (new Admin);
        $Admin->setName('Admin');
        $Admin->setEmail('admin@admin.com');
        $Admin->setPassword('123456');
        $Admin->save();
        $Role = new Role();
        $Role->setName('Admin');
        $Role->save();
        $Role->refresh();
        $Permissions = [
            'Admins',
            'Roles',
            'Permissions',
            'Settings',
            'Faq',
            'Users',
            'Tickets',
            'Categories',
            'Countries',
            'Cities',
            'Advertisements',
        ];
        $Settings = [
            'privacy'=>[
                'name'=>'Privacy Policy',
                'name_ar'=>'سياسة الخصوصية',
                'value'=>'Privacy Policy',
                'value_ar'=>'سياسة الخصوصية',
                'key'=>'privacy',
                'type'=>Constant::SETTING_TYPE['Page'],
            ],
            'about'=>[
                'name'=>'About Us',
                'name_ar'=>'من نحن',
                'value'=>'About Us',
                'value_ar'=>'من نحن',
                'key'=>'about',
                'type'=>Constant::SETTING_TYPE['Page'],
            ],
            'terms'=>[
                'name'=>'Terms And Conditions',
                'name_ar'=>'الشروط والأحكام',
                'value'=>'Terms And Conditions',
                'value_ar'=>'الشروط والأحكام',
                'key'=>'terms',
                'type'=>Constant::SETTING_TYPE['Page'],
            ],
            'facebook'=>[
                'name'=>'Facebook',
                'name_ar'=>'حساب الفيسبوك',
                'value'=>'',
                'value_ar'=>'',
                'key'=>'facebook',
                'type'=>Constant::SETTING_TYPE['Values'],
            ],
            'instagram'=>[
                'name'=>'Instagram',
                'name_ar'=>'حساب الانستقرام',
                'value'=>'',
                'value_ar'=>'',
                'key'=>'instagram',
                'type'=>Constant::SETTING_TYPE['Values'],
            ],
            'email'=>[
                'name'=>'Email',
                'name_ar'=>'البريد الالكتروني',
                'value'=>'',
                'value_ar'=>'',
                'key'=>'email',
                'type'=>Constant::SETTING_TYPE['Values'],
            ],
            'mobile'=>[
                'name'=>'Mobile',
                'name_ar'=>'رقم الجوال',
                'value'=>'',
                'value_ar'=>'',
                'key'=>'mobile',
                'type'=>Constant::SETTING_TYPE['Values'],
            ],
        ];
        foreach ($Settings as $setting){
            $Setting = new Setting();
            $Setting->setKey($setting['key']);
            $Setting->setName($setting['name']);
            $Setting->setNameAr($setting['name_ar']);
            $Setting->setValue($setting['value']);
            $Setting->setValueAr($setting['value_ar']);
            $Setting->setType($setting['type']);
            $Setting->save();
        }
        foreach ($Permissions as $permission){
            $Permission = new Permission;
            $Permission->setName($permission);
            $Permission->save();
        }
        foreach (Permission::all() as $permission){
            $RolePermission = new RolePermission();
            $RolePermission->setPermissionId($permission->getId());
            $RolePermission->setRoleId($Role->getId());
            $RolePermission->save();
        }
        foreach (Role::all() as $role){
            $ModelRole = new ModelRole();
            $ModelRole->setModelId($Admin->getId());
            $ModelRole->setRoleId($role->getId());
            $ModelRole->save();
        }
        foreach (Permission::all() as $permission){
            $ModelPermission = new ModelPermission();
            $ModelPermission->setModelId($Admin->getId());
            $ModelPermission->setPermissionId($permission->getId());
            $ModelPermission->save();
        }
        Artisan::call('passport:install');
    }
}
