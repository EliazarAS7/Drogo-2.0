<thead>
    <tr>
        <th>Referencia Pedido</th>
        <th>Fecha Pedido</th>
        <th>Importe</th>
        <th>Locker del envio</th>
        <th>Dirección</th>
        <!-- En el caso del comprador -->
        <?php if($tipo=='Comprador'){?>
            <th>Fecha Recogida</th>    
        <!-- En el caso del vendedor -->
        <?php } else if($tipo=='Vendedor'){?>
            <th>Fecha Deposito</th>
            <th>Cargo de Transporte</th>
            <th>Cargos Adicionales</th>
            <th>Distribuidor</th>
        <!-- En el caso del administrador -->
        <?php } else if($tipo=='Administrador'){ ?>
            <th>Fecha Recogida</th>
            <th>Fecha Deposito</th>
            <th>Cargo de Transporte</th>
            <th>Cargos Adicionales</th>
            <th>Comprador</th>
            <th>Vendedor</th>
            <th>Distribuidor</th>
            <th>Operaciones</th>
        <?php } ?>
    </tr>
</thead>
<tbody>
<?php foreach ($pedidos as $pedido): ?>
    <tr>
        <td><?= $pedido->refCompra?></td>
        <td><?= $pedido->fechaCompra?></td>
        <td><?= $pedido->importe?></td>
        <td><?= $pedido->refLocker?></td>
        <!-- Hay que hacerlo así ya que si no al pasar a la página 2 no aparece la direccion -->
        <?php for($x=0; $x<count($direccion); $x++){ 
            if($direccion[$x][0]==$pedido->refLocker){?>
            <td class="direccion"><?= $direccion[$x][1]?></td>
        <?php } } ?>
        <!-- En el caso del comprador -->
        <?php if($tipo=='Comprador'){?>
            <td><?= $pedido->fechaRecogida?></td>
        <!-- En el caso del vendedor -->
        <?php } else if($tipo=='Vendedor'){?>
            <td><?= $pedido->fechaDeposito?></td>
            <td><?= $pedido->cargoTransporte?></td>
            <td><?= $pedido->cargosAdicionales?></td> 
            <!-- Dependiendo de si hay distribución o no aparece una cosa u otra -->
            <td>
                <div class="row">
                    <p><?= $pedido->distribuidor==1?'Si':'No'?></p>
                    <?php 
                        if($pedido->distribuidor==1){?>
                            <a href="/actualizarEnvio?id=<?= $pedido->refCompra; ?>" class="act"><img src="../build/img/icons/edit.svg" alt=""></a>
                    <?php } ?>
                </div>
            </td> 
            <!-- En el caso del administrador -->
        <?php } else if($tipo=='Administrador'){ ?>
            <td><?= $pedido->fechaRecogida?></td>
            <td><?= $pedido->fechaDeposito?></td>
            <td><?= $pedido->cargoTransporte?></td>
            <td><?= $pedido->cargosAdicionales?></td>
            <?php foreach ($users as $user) :?>
                    <?php if($user->id==$pedido->hash_comprador){ echo "<td>".$user->username."</td>";}?>
            <?php endforeach; ?>   
            <?php foreach ($users as $user) :?>
                <?php if($user->id==$pedido->hash_vendedor){ echo "<td>".$user->username."</td>";}?>
            <?php endforeach; ?> 

            <!-- Dependiendo de si hay distribución o no aparece una cosa u otra -->
            <td>
                <div class="row">
                    <p><?= $pedido->distribuidor==1?'Si':'No'?></p>
                    <?php 
                        if($pedido->distribuidor==1){?>
                            <a href="/actualizarEnvio?id=<?= $pedido->refCompra; ?>" class="act"><img src="../build/img/icons/edit.svg" alt=""></a>
                    <?php } ?>
                </div>
            </td> 
            <td>
                <!-- Formulario para eliminar el pedido seleccionado -->
                <div class="bloque">
                    <form action="/borrarPedido?id=<?= $pedido->refCompra; ?>" method="post" onsubmit="return confirmEliminado()" class="formEliminado">
                        <input class="bTabla" type="submit" name="borrar" value=" ">
                        <input class="oculto" type="hidden" name="refCompra" value=<?= $pedido->refCompra;?>>
                    </form>
                    <a href="/actualizarPedido?id=<?= $pedido->refCompra;?>" class="bTabla act"><img src="../build/img/icons/writer.svg" alt=""></a>
        </div>
        <?php } ?>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>