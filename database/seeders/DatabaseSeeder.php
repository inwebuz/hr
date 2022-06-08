<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TranslationsTableSeeder::class,
            DataTypesTableSeeder::class,
            DataRowsTableSeeder::class,
            MenusTableSeeder::class,
            MenuItemsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            PermissionRoleTableSeeder::class,

            SettingsTableSeeder::class,

            UsersTableSeeder::class,
            PagesTableSeeder::class,
            StaticTextsTableSeeder::class,
            // RegionsTableSeeder::class,
            // WarehousesTableSeeder::class,

            BannersTableSeeder::class,
            // PromotionsTableSeeder::class,

            // InstallmentPlansTableSeeder::class,
            // GendersTableSeeder::class,
            // CategoriesTableSeeder::class,
            // BrandsTableSeeder::class,
            PartnersTableSeeder::class,
            // RubricsTableSeeder::class,

            // AttributesTableSeeder::class,
            // AttributeValuesTableSeeder::class,

            // ProductsTableSeeder::class,
            PublicationsTableSeeder::class,
            ServicesTableSeeder::class,
            // ShippingMethodSeeder::class,

            // PricelistsTableSeeder::class,

            // ArticlesTableSeeder::class,
            // NewsTableSeeder::class,

            VacanciesTableSeeder::class,
            // CVsTableSeeder::class,

            GalleriesTableSeeder::class,

            ReviewsTableSeeder::class,
            // FixedCompaniesTableSeeder::class,

            // PollsTableSeeder::class,
            EmployeesTableSeeder::class,

        ]);
    }
}
