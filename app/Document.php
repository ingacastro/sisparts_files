<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['type','number','reference','customer_code','seller_number','state', 'status',
    					   'currency_id','mxn_currency_exchange_rate','customer_requirement_number',
    					   'buyer_name','buyer_number','customers_id', 'sync_connections_id', 'employees_users_id',
                 'completed_date', 'was_canceled', 'is_canceled', 'cop_nom','con_con','fel_doc','fec_doc',
                 'im1_doc','im2_doc','im4_doc','im5_doc','com_doc','vm4_doc','vm5_doc','sal_doc','ob1_doc',
                 'sau_doc','fau_doc','rut_rut','num_pry','che_doc','usu_usu','tor_doc','nor_doc','im0_doc',
                 'mov_doc','fip_doc','tpa_doc','rpa_doc','tip_tdn','npa_doc','mpa_sat','fpa_sat','uso_sat',
                 'ndr_doc','dto_doc', 'mon_doc', 'vmo_doc', 'vm2_doc', 'vm3_doc', 'siavcom_ctz', 'siavcom_ctz_number', 'archive_user'];

   	public function supplies()
   	{
   		return $this->belongsToMany('IParts\Supply', 'documents_supplies', 'documents_id', 'supplies_id')
   		->withPivot('id', 'set', 'product_description', 'products_amount', 'sale_unit_cost', 'status');
   	}
   	public function dealership()
   	{
   		return $this->hasOne('IParts\Employee', 'users_id', 'employees_users_id');
   	}
    public function sync_connection()
    {
      return $this->hasOne('IParts\SyncConnection', 'id', 'sync_connections_id');
    }
    public function customer()
    {
      return $this->hasOne('IParts\Customer', 'id', 'customers_id');
    }
    public function currency()
    {
      return $this->hasOne('IParts\Currency', 'id', 'currency_id');
    }
    public function supply_sets()
    {
      return $this->hasMany('IParts\SupplySet', 'documents_id');
    }
}
