<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10"><?=$title?></h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item" style="line-height: 2.5">
            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?=base_url('admin_panel/tickets')?>" style="line-height: 2.5"><?=$title?></a>
         </li>
         <!-- <a style="float: left; color: white" href="<?=base_url('admin_panel/tickets/add')?>" class="btn btn-grd-primary">اضافة دولة جديده</a> -->
      </ul>
   </div>
</div>
<div class="page-body">
   <?php if ($this->session->flashdata('message')) { ?>
     <?=$this->session->flashdata('message');?>
  <?php } ?>
   <div class="card">
      <div class="card-header">
         <h5><?=$title?></h5>
      </div>
      <div class="card-block">
         <div class="dt-responsive table-responsive">
            <table id="order-table" class="table table-striped table-bordered nowrap">
               <thead>
                  <tr>
                     <th>مسلسل</th>  
                     <th>نوع التذكرة</th>
                     <th>محتوى التذكرة</th>
                     <th>تاريخ الانشاء</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $count = 1;
                  foreach($tickets as $ticket){ ?>
                    <tr>
                        <td><?=$count++?></td>
                        <td><?=get_this('tickets_types',['id'=>$ticket->ticket_type_id],'name')?></td>
                        <td><?=word_limiter($ticket->content,5)?></td>
                        <td><?=$ticket->created_at?></td>
                        <td><a href="<?=base_url('admin_panel/tickets/reply/'.$ticket->id)?>" class="btn btn-success ">رد</a></td>
                    </tr>
                  <?php } ?>
            </table>
         </div>
      </div>
   </div>
</div>