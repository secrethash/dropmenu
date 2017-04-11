<?php echo '<?php' ?>

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class SecrethashMenusTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('parent_id');
            $table->integer('order_by');
            $table->char('link', 255);
            $table->char('link_attr', 255);
            $table->char('icon', 255);
            $table->char('used_on', 255);
            $table->boolean('ext');
            $table->char('type', 255);
            $table->integer('viewable');
            $table->integer('auth');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menus');
    }
}
