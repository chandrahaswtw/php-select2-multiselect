<?php
$searchName = $_POST["name"] ?? '';
$searchFeatures = $_POST["features"] ?? [];
$searchProject = $_POST["project"] ?? "";
?>


<h1 class="navbar">MULTI SELECT DROPDOWN DEMO</h1>
<div class="container">
    <form method="post" class="p-4 grid grid-cols-none gap-2 shadow-sm rounded-md">
        <h2 class="form-title">Search</h2>
        <div class="form-contents">
            <label for="name">Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($searchName ?? "") ?>">

            <label for="features">Features</label>
            <div>
                <select id="features" name="features[]" multiple="multiple">
                    <?php foreach ($searchFeatures as $feature) : ?>
                        <option value="<?= htmlspecialchars($feature) ?>" selected="selected"><?= htmlspecialchars($feature) ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <label for="project">Projects</label>
            <div>
                <select id="project" name="project" data-allow-clear="true">
                    <?php if ($searchProject) : ?>
                        <option value="<?= htmlspecialchars($searchProject) ?>" selected="selected"><?= htmlspecialchars($searchProject) ?></option>
                    <?php endif ?>
                </select>
            </div>
        </div>
        <button class="btn btn-primary submit-btn">Submit</button>
    </form>
    <div>

        <?php

        use MS\DB;

        $config = require(basePath("config/_db.php"));
        $db = new DB($config);

        $fetchedRecordsQuery = "SELECT * FROM random_data";
        $fetchedRecordsParams = [];
        $conditions = [];
        if ($searchName) {
            $conditions[] = "name LIKE ?";
            $fetchedRecordsParams[] = "%{$searchName}%";
        }
        if ($searchFeatures) {
            $placeholders = implode(',', array_fill(0, count($searchFeatures), '?'));
            $conditions[] = "features in ($placeholders)";
            $fetchedRecordsParams = array_merge($fetchedRecordsParams, $searchFeatures);
        }
        if ($searchProject) {
            $conditions[] = "projects = ?";
            $fetchedRecordsParams[] = $searchProject;
        }
        if (!empty($conditions)) {
            $fetchedRecordsQuery .= " WHERE " . implode(" OR ",  $conditions);
        }

        $fetchedRecordsQuery .= " LIMIT 50";

        $fetchedRecords = $db->query($fetchedRecordsQuery, $fetchedRecordsParams)->fetchAll();
        ?>
        <?php if ($fetchedRecords && count($fetchedRecords)) : ?>
            <table class="features-projects-table">
                </caption>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Feature</th>
                        <th>Project</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fetchedRecords as $record) :  ?>
                        <tr>
                            <td><?= $record["name"] ?></td>
                            <td><?= $record["features"] ?></td>
                            <td><?= $record["projects"] ?></td>
                            <td><?= $record["status"] ?></td>
                        </tr>
                    <?php endforeach  ?>
                </tbody>
            </table>

        <?php else : ?>
            <p class="no-records">No records to show</p>
        <?php endif ?>
    </div>
</div>
</div>

<script>
    // Features - Multi select
    $(document).ready(function() {

        $('#features').select2({
            tags: false,
            placeholder: '',
            allowClear: true,
            ajax: {
                url: '/api/features',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }
                    // Query parameters will be ?search=[term]&page=[page]
                    return query;
                },
            }
        });

        // Projects - Single select
        $('#project').select2({
            tags: false,
            placeholder: '',
            allowClear: true,
            ajax: {
                url: '/api/projects',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }
                    // Query parameters will be ?search=[term]&page=[page]
                    return query;
                }
            }
        });
    });
</script>