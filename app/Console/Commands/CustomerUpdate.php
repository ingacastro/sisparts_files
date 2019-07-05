<?php

namespace IParts\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;
use IParts\Customer;
use DB;

class CustomerUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siavcom:customer-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Siavcom customer update.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->main();
    }

    public function main()
    {
        $sync_connections = DB::table('sync_connections')->get();
        foreach($sync_connections as $conn) {
            $this->connectAndUpdate($conn);
        }
    }

    private function connectAndUpdate(\stdClass $conn)
    {
        $customersTable = config('siavcom_sync.siavcom_customers');

        //Single test ->where('cod_nom', 'CL020012')
        $siavcomCustomers = DB::connection($conn->name)->table($customersTable)
        ->get();

        try {
            foreach($siavcomCustomers as $siavcomCustomer) {
                $this->updateCustomer($siavcomCustomer, $conn);
            }
        }catch(\Exception $e) {
            Log::notice($e->getMessage());
        }
    }

    private function updateCustomer(\stdClass $siavcomCustomer, \stdClass $conn)
    {
        $customer = Customer::where('code', $siavcomCustomer->cod_nom)
                    ->where('sync_connections_id', $conn->id)
                    ->first();

        if(!$customer) return;

        $data = [
                'trade_name' => $siavcomCustomer->cli_nom,
                'business_name' => $siavcomCustomer->nom_nom,
                'post_code' => $siavcomCustomer->cpo_nom,
                'state' => $siavcomCustomer->edo_edo,
<<<<<<< HEAD
                'country' => $siavcomCustomer->pai_nom,
                'type' => $siavcomCustomer->tip_tdn
=======
                'country' => $siavcomCustomer->pai_nom
>>>>>>> bcb3529f8d5412b84105d5884c5f50c4b9770d0e
            ];

        $customer->fill($data)->update();
    }
}
