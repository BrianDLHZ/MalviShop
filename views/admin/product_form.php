<?php require(BASE_PATH . '/views/admin/partials/header.php'); ?>

<main class="admin-main">
    <div class="admin-container">
        <div class="admin-page-header">
            <h1 class="admin-title"><?php echo isset($producto) ? 'Editar Producto' : 'Añadir Nuevo Producto'; ?></h1>
            <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/productos" class="button">Volver a la Lista</a>
        </div>
        
        <div class="form-container-admin">
            <form action="<?php echo htmlspecialchars($baseUrl); ?>/admin/<?php echo isset($producto) ? 'editar_producto/' . $producto['id'] : 'agregar_producto'; ?>" method="POST" enctype="multipart/form-data">
                
                <?php if (!empty($errors)): ?>
                    <div class="alert is-error">
                        <div class="alert-icon"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg></div>
                        <div class="alert-message">
                            <strong>Por favor, corrige los siguientes errores:</strong>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                <fieldset>
                    <legend>Información Básica</legend>
                    <div class="form-row-admin">
                        <div class="form-group-admin">
                            <label for="nombre">Nombre del Producto</label>
                            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($old_input['nombre'] ?? ($producto['nombre'] ?? '')); ?>" required>
                        </div>
                        <div class="form-group-admin">
                            <label for="marca">Marca</label>
                            <input type="text" id="marca" name="marca" value="<?php echo htmlspecialchars($old_input['marca'] ?? ($producto['marca'] ?? '')); ?>" required>
                        </div>
                    </div>
                    <div class="form-group-admin">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="5"><?php echo htmlspecialchars($old_input['descripcion'] ?? ($producto['descripcion'] ?? '')); ?></textarea>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Detalles de Inventario y Precio</legend>
                    <div class="form-row-admin">
                        <div class="form-group-admin">
                            <label for="codigo">Código (SKU)</label>
                            <input type="text" id="codigo" name="codigo" value="<?php echo htmlspecialchars($old_input['codigo'] ?? ($producto['codigo'] ?? '')); ?>" required>
                        </div>
                        <div class="form-group-admin">
                            <label for="categoria_id">Categoría</label>
                            <select id="categoria_id" name="categoria_id">
                                <option value="">Sin categoría</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?php echo $categoria['id']; ?>" 
                                        <?php 
                                        $selected_cat = $old_input['categoria_id'] ?? ($producto['categoria_id'] ?? '');
                                        if ($selected_cat == $categoria['id']) echo 'selected'; 
                                        ?>>
                                        <?php echo htmlspecialchars($categoria['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row-admin">
                        <div class="form-group-admin">
                            <label for="precio">Precio</label>
                            <input type="number" id="precio" name="precio" step="0.01" value="<?php echo htmlspecialchars($old_input['precio'] ?? ($producto['precio'] ?? '')); ?>" required>
                        </div>
                        <div class="form-group-admin">
                            <label for="stock">Stock</label>
                            <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($old_input['stock'] ?? ($producto['stock'] ?? '0')); ?>" required>
                        </div>
                    </div>
                </fieldset>
                
                <fieldset>
                    <legend>Imagen y Visibilidad</legend>
                     <div class="form-group-admin">
                        <label for="imagen_principal">Imagen Principal</label>
                        <input type="file" id="imagen_principal" name="imagen_principal" accept="image/jpeg, image/png">
                        <?php if (isset($producto['imagen_principal']) && !empty($producto['imagen_principal'])): ?>
                            <p class="current-image">Imagen actual: <?php echo htmlspecialchars($producto['imagen_principal']); ?>. Sube un nuevo archivo solo si deseas reemplazarla.</p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group-admin form-checkbox-group">
                        <label>
                            <input type="checkbox" name="activo" value="1" <?php echo (isset($old_input['activo']) && $old_input['activo']) || (isset($producto['activo']) && $producto['activo']) ? 'checked' : (!isset($producto) ? 'checked' : ''); ?>>
                            Producto Activo (visible en la tienda)
                        </label>
                        <label>
                            <input type="checkbox" name="destacado" value="1" <?php echo (isset($old_input['destacado']) && $old_input['destacado']) || (isset($producto['destacado']) && $producto['destacado']) ? 'checked' : ''; ?>>
                            Producto Destacado (aparece en la home)
                        </label>
                    </div>
                </fieldset>

                <button type="submit" class="button button-primary"><?php echo isset($producto) ? 'Actualizar Producto' : 'Guardar Producto'; ?></button>
            </form>
        </div>
    </div>
</main>

<?php require(BASE_PATH . '/views/admin/partials/footer.php'); ?>