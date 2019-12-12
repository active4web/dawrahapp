<div class="page-header card">

   <div class="card-block">

      <h5 class="m-b-10"><?=$title?></h5>

      <ul class="breadcrumb-title b-t-default p-t-10">

         <li class="breadcrumb-item" style="line-height: 2.5">

            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>

         </li>

         <li class="breadcrumb-item"><a href="<?=base_url('admin_panel/users')?>" style="line-height: 2.5"><?=$title?></a>

         </li>

         <a style="float: left; color: white" href="<?=base_url('admin_panel/users/add')?>" class="btn btn-grd-primary">اضافة مستخدم جديد</a>

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

                     <th>الاسم بالكامل</th>  

                     <th>اسم المستخدم</th>

                     <th>البريد الالكتروني</th>

                     <th>العمليات</th>

                  </tr>

               </thead>

               <tbody>

                  <?php $count = 1;

                  foreach($admins as $admin){ ?>

                    <tr>

                        <td><?=$count++?></td>

                        <td><?=$admin->full_name?></td>

                        <td><?=$admin->user_name?></td>

                        <td><?=$admin->email?></td>

                        <td><a href="<?=base_url('admin_panel/users/edit/'.$admin->user_id)?>" class="btn btn-warning ">تعديل</a> <button value="<?=$admin->user_id?>" type="button" class="btn btn-danger waves-effect" data-toggle="modal" data-target="#default-Modal" onclick="deletefn(this.value)">حذف</button></td>

                    </tr>

                  <?php } ?>

            </table>

         </div>

      </div>

   </div>

</div>

<div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">تأكيد الحذف</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <p>هل انت متاكد من انك تريد حذف هذا المستخدم ؟</p>

            </div>

            <div class="modal-footer">

                <a id="yes" style="margin-left: 5px; color: white" class="btn btn-danger waves-effect ">حذف</a>

                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</a>

            </div>

        </div>

    </div>

</div>

<script>

        function deletefn(val){

        var a = document.getElementById('yes');

        a.href = "<?=base_url('admin_panel/users/delete/')?>"+val;



        }

</script>