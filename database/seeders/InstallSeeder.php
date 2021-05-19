<?php
namespace Database\Seeders;

use App\Helpers\Constant;
use App\Models\Admin;
use App\Models\Link;
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
        $Role->setName('Super Admin');
        $Role->setNameAr('مدير عام');
        $Role->save();
        $Role->refresh();
        $PermissionsAndLinks = [
            'AppManagement'=>[
                'name'=>'App Management',
                'name_ar'=>'إدارة التطبيق',
                'key'=>'app_managements',
                'Children'=>[
                    'Admins'=>[
                        'name'=>'Employees',
                        'name_ar'=>'الموظفين',
                        'key'=>'employees',
                        'icon'=>'group'
                    ],
                    'Roles'=>[
                        'name'=>'Roles',
                        'name_ar'=>'الأدوار',
                        'key'=>'roles',
                        'icon'=>'accessibility'
                    ],
                    'Permissions'=>[
                        'name'=>'Permissions',
                        'name_ar'=>'الصلاحيات',
                        'key'=>'permissions',
                        'icon'=>'vpn_key'
                    ],
                ]
            ],
            'AppData'=>[
                'name'=>'App Data',
                'name_ar'=>'بيانات التطبيق',
                'key'=>'app_data',
                'Children'=>[
                    'Settings'=>[
                        'name'=>'Settings',
                        'name_ar'=>'الإعدادات',
                        'key'=>'settings',
                        'icon'=>'settings'
                    ],
                    'FAQs'=>[
                        'name'=>'FAQs',
                        'name_ar'=>'الأسئلة',
                        'key'=>'faqs',
                        'icon'=>'help'
                    ],
                    'Categories'=>[
                        'name'=>'Main Categories',
                        'name_ar'=>'التصنيفات الرئيسية',
                        'key'=>'categories',
                        'icon'=>'category'
                    ],
                    'SubCategories'=>[
                        'name'=>'Sub Categories',
                        'name_ar'=>'التصنيفات الفرعية',
                        'key'=>'sub_categories',
                        'icon'=>'widgets'
                    ],
                    'Countries'=>[
                        'name'=>'Countries',
                        'name_ar'=>'الدول',
                        'key'=>'countries',
                        'icon'=>'language'
                    ],
                    'Cities'=>[
                        'name'=>'Cities',
                        'name_ar'=>'المدن',
                        'key'=>'cities',
                        'icon'=>'location_city'
                    ],
                ]
            ],
            'AppContent'=>[
                'name'=>'App Content',
                'name_ar'=>'محتوى التطبيق',
                'key'=>'app_content',
                'Children'=>[
                    'Advertisements'=>[
                        'name'=>'Advertisements',
                        'name_ar'=>'الإعلانات',
                        'key'=>'advertisements',
                        'icon'=>'font_download'
                    ],
                    'Discounts'=>[
                        'name'=>'Discounts',
                        'name_ar'=>'أكواد الخصم',
                        'key'=>'discounts',
                        'icon'=>'local_offer'
                    ],
                    'Orders'=>[
                        'name'=>'Orders',
                        'name_ar'=>'الطلبات',
                        'key'=>'orders',
                        'icon'=>'category'
                    ],
                    'Chats'=>[
                        'name'=>'Chats',
                        'name_ar'=>'الدردشة',
                        'key'=>'chats',
                        'icon'=>'chat'
                    ],
                ]
            ],
            'UsersManagements'=>[
                'name'=>'Users Managements',
                'name_ar'=>'إدارة المستخدمين',
                'key'=>'user_managements',
                'Children'=>[
                    'Customers'=>[
                        'name'=>'Customers',
                        'name_ar'=>'الزبائن',
                        'key'=>'customers',
                        'icon'=>'group'
                    ],
                    'Providers'=>[
                        'name'=>'Providers',
                        'name_ar'=>'مزودي الخدمة',
                        'key'=>'providers',
                        'icon'=>'people_outline'
                    ],
                    'Tickets'=>[
                        'name'=>'Tickets',
                        'name_ar'=>'التذاكر',
                        'key'=>'tickets',
                        'icon'=>'label'
                    ],
                ]
            ],
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
            'footer_about'=>[
                'name'=>'Footer About Us',
                'name_ar'=>'من نحن الفوتر',
                'value'=>'Footer About Us',
                'value_ar'=>' من نحن الفوتر',
                'key'=>'footer_about',
                'type'=>Constant::SETTING_TYPE['Page'],
            ],
            'goals'=>[
                'name'=>'Our Goals',
                'name_ar'=>'أهدافنا',
                'value'=>'Our Goals',
                'value_ar'=>'أهدافنا',
                'key'=>'goals',
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
            'holding_period'=>[
                'name'=>'Holding Period',
                'name_ar'=>'فترة الحجز',
                'value'=>'10',
                'value_ar'=>'10',
                'key'=>'holding_period',
                'type'=>Constant::SETTING_TYPE['Values'],
            ],
            'commission'=>[
                'name'=>'Commission',
                'name_ar'=>'العمولة',
                'value'=>'2',
                'value_ar'=>'2',
                'key'=>'commission',
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
        foreach ($PermissionsAndLinks as $object){
            $Permission = new Permission();
            $Permission->setName($object['name']);
            $Permission->setNameAr($object['name_ar']);
            $Permission->setKey($object['key']);
            $Permission->save();
            $Permission->refresh();
            $Link = new Link();
            $Link->setName($object['name']);
            $Link->setNameAr($object['name_ar']);
            $Link->setUrl($object['key']);
            $Link->setPermissionId($Permission->getId());
            $Link->save();
            $Link->refresh();
            foreach ($object['Children'] as $child){
                $CPermission = new Permission();
                $CPermission->setName($child['name']);
                $CPermission->setNameAr($child['name_ar']);
                $CPermission->setKey($child['key']);
                $CPermission->setParentId($Permission->getId());
                $CPermission->save();
                $CLink = new Link();
                $CLink->setName($child['name']);
                $CLink->setNameAr($child['name_ar']);
                $CLink->setUrl($child['key']);
                $CLink->setIcon($child['icon']);
                $CLink->setParentId($Link->getId());
                $CLink->setPermissionId($CPermission->getId());
                $CLink->save();
            }
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
