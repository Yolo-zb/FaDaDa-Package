<?php

namespace Zhuobin\FaDaDa\Src\Console;

use Illuminate\Console\Command;

class FadadaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fadada:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Signature';

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
        $dist_path = config_path();
        $is_copy = copy(__DIR__ . '/stubs/config.stub', $dist_path . '/fadada.php');
        if (!$is_copy) {
            $this->error('创建配置文件signature.php文件失败,请确保' . dirname($dist_path) . '目录有权限!');
            return false;
        } else {
            $this->info('创建配置文件signature.php成功');
        }
    }
}
