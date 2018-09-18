{extend name="public/container"}
{block name="content"}
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>数据库表列表</h5>
            </div>
            <div class="ibox-content" style="display: block;">
                <div class="table-responsive">
                    <div class="layui-btn-group conrelTable">
                        <button class="layui-btn layui-btn-sm layui-btn-normal" type="button" data-type="backup"><i class="fa fa-check-circle-o"></i>备份</button>
                        <button class="layui-btn layui-btn-sm layui-btn-normal" type="button" data-type="optimize"><i class="fa fa-check-circle-o"></i>优化表</button>
                        <button class="layui-btn layui-btn-sm layui-btn-normal" type="button" data-type="repair"><i class="fa fa-check-circle-o"></i>修复表</button>
                        <button class="layui-btn layui-btn-sm layui-btn-normal" type="button" data-type="refresh"><i class="layui-icon layui-icon-refresh" ></i>刷新</button>
                    </div>
                    <table class="layui-hide" id="userList" lay-filter="userList"></table>
                    <script type="text/html" id="barDemo">
                        <button type="button" class="layui-btn layui-btn-xs" lay-event="see"><i class="layui-icon layui-icon-edit"></i>详情</button>
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{__ADMIN_PATH}js/layuiList.js"></script>
<script>
    //加载table
    layList.tableList('userList',"{:Url('tablelist')}",function () {
        return [
            {type:'checkbox'},
            {field: 'name', title: '表名称'},
            {field: 'comment', title: '备注' },
            {field: 'engine', title: '类型'},
            {field: 'data_length', title: '大小'},
            {field: 'update_time', title: '更新时间'},
            {field: 'rows', title: '行数'},
            {fixed: 'right', title: '操作', width: '10%', align: 'center', toolbar: '#barDemo'}
        ];
    },100);
    layList.reload();
    //监听并执行 uid 的排序
    layList.tool(function (event,data) {
        var layEvent = event;
        switch (layEvent){
            case 'see':
                $eb.createModalFrame('详情',layList.Url({a:'edit',p:{uid:data.name}}));
                break;
        }
    });
    var action={
        optimize:function () {
            var tables=layList.getCheckData().getIds('name');
            if(tables.length){
                layList.basePost(layList.Url({a:'optimize'}),{tables:tables},function (res) {
                    layList.msg(res.msg);
//                    layList.reload();
                });
            }else{
                layList.msg('请选择表');
            }
        },
        repair:function () {
            var tables=layList.getCheckData().getIds('name');
            if(tables.length){
                layList.basePost(layList.Url({a:'repair'}),{tables:tables},function (res) {
                    layList.msg(res.msg);
//                    layList.reload();
                });
            }else{
                layList.msg('请选择表');
            }
        },
        backup:function () {
            var tables=layList.getCheckData().getIds('name');
            if(tables.length){
                layList.basePost(layList.Url({a:'backup'}),{tables:tables},function (res) {
                    layList.msg(res.msg);
//                    layList.reload();
                });
            }else{
                layList.msg('请选择表');
            }
        },

    };
    $('.conrelTable').find('button').each(function () {
        var type=$(this).data('type');
        $(this).on('click',function () {
            action[type] && action[type]();
        })
    })

</script>
{/block}