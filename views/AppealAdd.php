<?php

namespace PHPMaker2024\project2;

// Page object
$AppealAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { appeal: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fappealadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fappealadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["AppealID", [fields.AppealID.visible && fields.AppealID.required ? ew.Validators.required(fields.AppealID.caption) : null], fields.AppealID.isInvalid],
            ["appealDate", [fields.appealDate.visible && fields.appealDate.required ? ew.Validators.required(fields.appealDate.caption) : null, ew.Validators.datetime(fields.appealDate.clientFormatPattern)], fields.appealDate.isInvalid],
            ["mid", [fields.mid.visible && fields.mid.required ? ew.Validators.required(fields.mid.caption) : null], fields.mid.isInvalid],
            ["rank", [fields.rank.visible && fields.rank.required ? ew.Validators.required(fields.rank.caption) : null], fields.rank.isInvalid],
            ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
            ["deptName", [fields.deptName.visible && fields.deptName.required ? ew.Validators.required(fields.deptName.caption) : null], fields.deptName.isInvalid],
            ["halafinet", [fields.halafinet.visible && fields.halafinet.required ? ew.Validators.required(fields.halafinet.caption) : null], fields.halafinet.isInvalid],
            ["crimstate", [fields.crimstate.visible && fields.crimstate.required ? ew.Validators.required(fields.crimstate.caption) : null], fields.crimstate.isInvalid],
            ["Description", [fields.Description.visible && fields.Description.required ? ew.Validators.required(fields.Description.caption) : null], fields.Description.isInvalid],
            ["midib", [fields.midib.visible && fields.midib.required ? ew.Validators.required(fields.midib.caption) : null], fields.midib.isInvalid],
            ["appealask", [fields.appealask.visible && fields.appealask.required ? ew.Validators.required(fields.appealask.caption) : null], fields.appealask.isInvalid],
            ["AppealDescription", [fields.AppealDescription.visible && fields.AppealDescription.required ? ew.Validators.required(fields.AppealDescription.caption) : null], fields.AppealDescription.isInvalid],
            ["appealDecision", [fields.appealDecision.visible && fields.appealDecision.required ? ew.Validators.required(fields.appealDecision.caption) : null], fields.appealDecision.isInvalid],
            ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(fields.created_at.clientFormatPattern)], fields.created_at.isInvalid],
            ["crimeDate", [fields.crimeDate.visible && fields.crimeDate.required ? ew.Validators.required(fields.crimeDate.caption) : null, ew.Validators.datetime(fields.crimeDate.clientFormatPattern)], fields.crimeDate.isInvalid],
            ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null], fields.updated_at.isInvalid],
            ["updated_by", [fields.updated_by.visible && fields.updated_by.required ? ew.Validators.required(fields.updated_by.caption) : null], fields.updated_by.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
            "AppealID": <?= $Page->AppealID->toClientList($Page) ?>,
            "mid": <?= $Page->mid->toClientList($Page) ?>,
            "rank": <?= $Page->rank->toClientList($Page) ?>,
            "deptName": <?= $Page->deptName->toClientList($Page) ?>,
            "midib": <?= $Page->midib->toClientList($Page) ?>,
            "appealask": <?= $Page->appealask->toClientList($Page) ?>,
            "AppealDescription": <?= $Page->AppealDescription->toClientList($Page) ?>,
            "appealDecision": <?= $Page->appealDecision->toClientList($Page) ?>,
        })
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fappealadd" id="fappealadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="appeal">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->AppealID->Visible) { // AppealID ?>
    <div id="r_AppealID"<?= $Page->AppealID->rowAttributes() ?>>
        <label id="elh_appeal_AppealID" for="x_AppealID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AppealID->caption() ?><?= $Page->AppealID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->AppealID->cellAttributes() ?>>
<span id="el_appeal_AppealID">
    <select
        id="x_AppealID"
        name="x_AppealID"
        class="form-select ew-select<?= $Page->AppealID->isInvalidClass() ?>"
        <?php if (!$Page->AppealID->IsNativeSelect) { ?>
        data-select2-id="fappealadd_x_AppealID"
        <?php } ?>
        data-table="appeal"
        data-field="x_AppealID"
        data-value-separator="<?= $Page->AppealID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->AppealID->getPlaceHolder()) ?>"
        <?= $Page->AppealID->editAttributes() ?>>
        <?= $Page->AppealID->selectOptionListHtml("x_AppealID") ?>
    </select>
    <?= $Page->AppealID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->AppealID->getErrorMessage() ?></div>
<?= $Page->AppealID->Lookup->getParamTag($Page, "p_x_AppealID") ?>
<?php if (!$Page->AppealID->IsNativeSelect) { ?>
<script>
loadjs.ready("fappealadd", function() {
    var options = { name: "x_AppealID", selectId: "fappealadd_x_AppealID" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fappealadd.lists.AppealID?.lookupOptions.length) {
        options.data = { id: "x_AppealID", form: "fappealadd" };
    } else {
        options.ajax = { id: "x_AppealID", form: "fappealadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.appeal.fields.AppealID.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->appealDate->Visible) { // appealDate ?>
    <div id="r_appealDate"<?= $Page->appealDate->rowAttributes() ?>>
        <label id="elh_appeal_appealDate" for="x_appealDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->appealDate->caption() ?><?= $Page->appealDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->appealDate->cellAttributes() ?>>
<span id="el_appeal_appealDate">
<input type="<?= $Page->appealDate->getInputTextType() ?>" name="x_appealDate" id="x_appealDate" data-table="appeal" data-field="x_appealDate" value="<?= $Page->appealDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->appealDate->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->appealDate->formatPattern()) ?>"<?= $Page->appealDate->editAttributes() ?> aria-describedby="x_appealDate_help">
<?= $Page->appealDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->appealDate->getErrorMessage() ?></div>
<?php if (!$Page->appealDate->ReadOnly && !$Page->appealDate->Disabled && !isset($Page->appealDate->EditAttrs["readonly"]) && !isset($Page->appealDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fappealadd", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fappealadd", "x_appealDate", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mid->Visible) { // mid ?>
    <div id="r_mid"<?= $Page->mid->rowAttributes() ?>>
        <label id="elh_appeal_mid" for="x_mid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mid->caption() ?><?= $Page->mid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->mid->cellAttributes() ?>>
<span id="el_appeal_mid">
    <select
        id="x_mid"
        name="x_mid"
        class="form-select ew-select<?= $Page->mid->isInvalidClass() ?>"
        <?php if (!$Page->mid->IsNativeSelect) { ?>
        data-select2-id="fappealadd_x_mid"
        <?php } ?>
        data-table="appeal"
        data-field="x_mid"
        data-value-separator="<?= $Page->mid->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->mid->getPlaceHolder()) ?>"
        <?= $Page->mid->editAttributes() ?>>
        <?= $Page->mid->selectOptionListHtml("x_mid") ?>
    </select>
    <?= $Page->mid->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->mid->getErrorMessage() ?></div>
<?= $Page->mid->Lookup->getParamTag($Page, "p_x_mid") ?>
<?php if (!$Page->mid->IsNativeSelect) { ?>
<script>
loadjs.ready("fappealadd", function() {
    var options = { name: "x_mid", selectId: "fappealadd_x_mid" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fappealadd.lists.mid?.lookupOptions.length) {
        options.data = { id: "x_mid", form: "fappealadd" };
    } else {
        options.ajax = { id: "x_mid", form: "fappealadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.appeal.fields.mid.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rank->Visible) { // rank ?>
    <div id="r_rank"<?= $Page->rank->rowAttributes() ?>>
        <label id="elh_appeal_rank" for="x_rank" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rank->caption() ?><?= $Page->rank->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rank->cellAttributes() ?>>
<span id="el_appeal_rank">
    <select
        id="x_rank"
        name="x_rank"
        class="form-select ew-select<?= $Page->rank->isInvalidClass() ?>"
        <?php if (!$Page->rank->IsNativeSelect) { ?>
        data-select2-id="fappealadd_x_rank"
        <?php } ?>
        data-table="appeal"
        data-field="x_rank"
        data-value-separator="<?= $Page->rank->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->rank->getPlaceHolder()) ?>"
        <?= $Page->rank->editAttributes() ?>>
        <?= $Page->rank->selectOptionListHtml("x_rank") ?>
    </select>
    <?= $Page->rank->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->rank->getErrorMessage() ?></div>
<?= $Page->rank->Lookup->getParamTag($Page, "p_x_rank") ?>
<?php if (!$Page->rank->IsNativeSelect) { ?>
<script>
loadjs.ready("fappealadd", function() {
    var options = { name: "x_rank", selectId: "fappealadd_x_rank" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fappealadd.lists.rank?.lookupOptions.length) {
        options.data = { id: "x_rank", form: "fappealadd" };
    } else {
        options.ajax = { id: "x_rank", form: "fappealadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.appeal.fields.rank.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name"<?= $Page->name->rowAttributes() ?>>
        <label id="elh_appeal_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name->cellAttributes() ?>>
<span id="el_appeal_name">
<input type="<?= $Page->name->getInputTextType() ?>" name="x_name" id="x_name" data-table="appeal" data-field="x_name" value="<?= $Page->name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name->formatPattern()) ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->deptName->Visible) { // deptName ?>
    <div id="r_deptName"<?= $Page->deptName->rowAttributes() ?>>
        <label id="elh_appeal_deptName" for="x_deptName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->deptName->caption() ?><?= $Page->deptName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->deptName->cellAttributes() ?>>
<span id="el_appeal_deptName">
    <select
        id="x_deptName"
        name="x_deptName"
        class="form-select ew-select<?= $Page->deptName->isInvalidClass() ?>"
        <?php if (!$Page->deptName->IsNativeSelect) { ?>
        data-select2-id="fappealadd_x_deptName"
        <?php } ?>
        data-table="appeal"
        data-field="x_deptName"
        data-value-separator="<?= $Page->deptName->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->deptName->getPlaceHolder()) ?>"
        <?= $Page->deptName->editAttributes() ?>>
        <?= $Page->deptName->selectOptionListHtml("x_deptName") ?>
    </select>
    <?= $Page->deptName->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->deptName->getErrorMessage() ?></div>
<?= $Page->deptName->Lookup->getParamTag($Page, "p_x_deptName") ?>
<?php if (!$Page->deptName->IsNativeSelect) { ?>
<script>
loadjs.ready("fappealadd", function() {
    var options = { name: "x_deptName", selectId: "fappealadd_x_deptName" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fappealadd.lists.deptName?.lookupOptions.length) {
        options.data = { id: "x_deptName", form: "fappealadd" };
    } else {
        options.ajax = { id: "x_deptName", form: "fappealadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.appeal.fields.deptName.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->halafinet->Visible) { // halafinet ?>
    <div id="r_halafinet"<?= $Page->halafinet->rowAttributes() ?>>
        <label id="elh_appeal_halafinet" for="x_halafinet" class="<?= $Page->LeftColumnClass ?>"><?= $Page->halafinet->caption() ?><?= $Page->halafinet->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->halafinet->cellAttributes() ?>>
<span id="el_appeal_halafinet">
<input type="<?= $Page->halafinet->getInputTextType() ?>" name="x_halafinet" id="x_halafinet" data-table="appeal" data-field="x_halafinet" value="<?= $Page->halafinet->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->halafinet->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->halafinet->formatPattern()) ?>"<?= $Page->halafinet->editAttributes() ?> aria-describedby="x_halafinet_help">
<?= $Page->halafinet->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->halafinet->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->crimstate->Visible) { // crimstate ?>
    <div id="r_crimstate"<?= $Page->crimstate->rowAttributes() ?>>
        <label id="elh_appeal_crimstate" for="x_crimstate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->crimstate->caption() ?><?= $Page->crimstate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->crimstate->cellAttributes() ?>>
<span id="el_appeal_crimstate">
<input type="<?= $Page->crimstate->getInputTextType() ?>" name="x_crimstate" id="x_crimstate" data-table="appeal" data-field="x_crimstate" value="<?= $Page->crimstate->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->crimstate->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->crimstate->formatPattern()) ?>"<?= $Page->crimstate->editAttributes() ?> aria-describedby="x_crimstate_help">
<?= $Page->crimstate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->crimstate->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
    <div id="r_Description"<?= $Page->Description->rowAttributes() ?>>
        <label id="elh_appeal_Description" for="x_Description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Description->caption() ?><?= $Page->Description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Description->cellAttributes() ?>>
<span id="el_appeal_Description">
<input type="<?= $Page->Description->getInputTextType() ?>" name="x_Description" id="x_Description" data-table="appeal" data-field="x_Description" value="<?= $Page->Description->EditValue ?>" size="30" maxlength="65535" placeholder="<?= HtmlEncode($Page->Description->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Description->formatPattern()) ?>"<?= $Page->Description->editAttributes() ?> aria-describedby="x_Description_help">
<?= $Page->Description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->midib->Visible) { // midib ?>
    <div id="r_midib"<?= $Page->midib->rowAttributes() ?>>
        <label id="elh_appeal_midib" for="x_midib" class="<?= $Page->LeftColumnClass ?>"><?= $Page->midib->caption() ?><?= $Page->midib->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->midib->cellAttributes() ?>>
<span id="el_appeal_midib">
    <select
        id="x_midib"
        name="x_midib"
        class="form-select ew-select<?= $Page->midib->isInvalidClass() ?>"
        <?php if (!$Page->midib->IsNativeSelect) { ?>
        data-select2-id="fappealadd_x_midib"
        <?php } ?>
        data-table="appeal"
        data-field="x_midib"
        data-value-separator="<?= $Page->midib->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->midib->getPlaceHolder()) ?>"
        <?= $Page->midib->editAttributes() ?>>
        <?= $Page->midib->selectOptionListHtml("x_midib") ?>
    </select>
    <?= $Page->midib->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->midib->getErrorMessage() ?></div>
<?= $Page->midib->Lookup->getParamTag($Page, "p_x_midib") ?>
<?php if (!$Page->midib->IsNativeSelect) { ?>
<script>
loadjs.ready("fappealadd", function() {
    var options = { name: "x_midib", selectId: "fappealadd_x_midib" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fappealadd.lists.midib?.lookupOptions.length) {
        options.data = { id: "x_midib", form: "fappealadd" };
    } else {
        options.ajax = { id: "x_midib", form: "fappealadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.appeal.fields.midib.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->appealask->Visible) { // appealask ?>
    <div id="r_appealask"<?= $Page->appealask->rowAttributes() ?>>
        <label id="elh_appeal_appealask" for="x_appealask" class="<?= $Page->LeftColumnClass ?>"><?= $Page->appealask->caption() ?><?= $Page->appealask->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->appealask->cellAttributes() ?>>
<span id="el_appeal_appealask">
    <select
        id="x_appealask"
        name="x_appealask"
        class="form-select ew-select<?= $Page->appealask->isInvalidClass() ?>"
        <?php if (!$Page->appealask->IsNativeSelect) { ?>
        data-select2-id="fappealadd_x_appealask"
        <?php } ?>
        data-table="appeal"
        data-field="x_appealask"
        data-value-separator="<?= $Page->appealask->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->appealask->getPlaceHolder()) ?>"
        <?= $Page->appealask->editAttributes() ?>>
        <?= $Page->appealask->selectOptionListHtml("x_appealask") ?>
    </select>
    <?= $Page->appealask->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->appealask->getErrorMessage() ?></div>
<?php if (!$Page->appealask->IsNativeSelect) { ?>
<script>
loadjs.ready("fappealadd", function() {
    var options = { name: "x_appealask", selectId: "fappealadd_x_appealask" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fappealadd.lists.appealask?.lookupOptions.length) {
        options.data = { id: "x_appealask", form: "fappealadd" };
    } else {
        options.ajax = { id: "x_appealask", form: "fappealadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.appeal.fields.appealask.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AppealDescription->Visible) { // AppealDescription ?>
    <div id="r_AppealDescription"<?= $Page->AppealDescription->rowAttributes() ?>>
        <label id="elh_appeal_AppealDescription" for="x_AppealDescription" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AppealDescription->caption() ?><?= $Page->AppealDescription->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->AppealDescription->cellAttributes() ?>>
<span id="el_appeal_AppealDescription">
    <select
        id="x_AppealDescription"
        name="x_AppealDescription"
        class="form-select ew-select<?= $Page->AppealDescription->isInvalidClass() ?>"
        <?php if (!$Page->AppealDescription->IsNativeSelect) { ?>
        data-select2-id="fappealadd_x_AppealDescription"
        <?php } ?>
        data-table="appeal"
        data-field="x_AppealDescription"
        data-value-separator="<?= $Page->AppealDescription->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->AppealDescription->getPlaceHolder()) ?>"
        <?= $Page->AppealDescription->editAttributes() ?>>
        <?= $Page->AppealDescription->selectOptionListHtml("x_AppealDescription") ?>
    </select>
    <?= $Page->AppealDescription->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->AppealDescription->getErrorMessage() ?></div>
<?php if (!$Page->AppealDescription->IsNativeSelect) { ?>
<script>
loadjs.ready("fappealadd", function() {
    var options = { name: "x_AppealDescription", selectId: "fappealadd_x_AppealDescription" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fappealadd.lists.AppealDescription?.lookupOptions.length) {
        options.data = { id: "x_AppealDescription", form: "fappealadd" };
    } else {
        options.ajax = { id: "x_AppealDescription", form: "fappealadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.appeal.fields.AppealDescription.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->appealDecision->Visible) { // appealDecision ?>
    <div id="r_appealDecision"<?= $Page->appealDecision->rowAttributes() ?>>
        <label id="elh_appeal_appealDecision" for="x_appealDecision" class="<?= $Page->LeftColumnClass ?>"><?= $Page->appealDecision->caption() ?><?= $Page->appealDecision->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->appealDecision->cellAttributes() ?>>
<span id="el_appeal_appealDecision">
    <select
        id="x_appealDecision"
        name="x_appealDecision"
        class="form-select ew-select<?= $Page->appealDecision->isInvalidClass() ?>"
        <?php if (!$Page->appealDecision->IsNativeSelect) { ?>
        data-select2-id="fappealadd_x_appealDecision"
        <?php } ?>
        data-table="appeal"
        data-field="x_appealDecision"
        data-value-separator="<?= $Page->appealDecision->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->appealDecision->getPlaceHolder()) ?>"
        <?= $Page->appealDecision->editAttributes() ?>>
        <?= $Page->appealDecision->selectOptionListHtml("x_appealDecision") ?>
    </select>
    <?= $Page->appealDecision->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->appealDecision->getErrorMessage() ?></div>
<?php if (!$Page->appealDecision->IsNativeSelect) { ?>
<script>
loadjs.ready("fappealadd", function() {
    var options = { name: "x_appealDecision", selectId: "fappealadd_x_appealDecision" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fappealadd.lists.appealDecision?.lookupOptions.length) {
        options.data = { id: "x_appealDecision", form: "fappealadd" };
    } else {
        options.ajax = { id: "x_appealDecision", form: "fappealadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.appeal.fields.appealDecision.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at"<?= $Page->created_at->rowAttributes() ?>>
        <label id="elh_appeal_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->created_at->cellAttributes() ?>>
<span id="el_appeal_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" name="x_created_at" id="x_created_at" data-table="appeal" data-field="x_created_at" value="<?= $Page->created_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->created_at->formatPattern()) ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fappealadd", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fappealadd", "x_created_at", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->crimeDate->Visible) { // crimeDate ?>
    <div id="r_crimeDate"<?= $Page->crimeDate->rowAttributes() ?>>
        <label id="elh_appeal_crimeDate" for="x_crimeDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->crimeDate->caption() ?><?= $Page->crimeDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->crimeDate->cellAttributes() ?>>
<span id="el_appeal_crimeDate">
<input type="<?= $Page->crimeDate->getInputTextType() ?>" name="x_crimeDate" id="x_crimeDate" data-table="appeal" data-field="x_crimeDate" value="<?= $Page->crimeDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->crimeDate->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->crimeDate->formatPattern()) ?>"<?= $Page->crimeDate->editAttributes() ?> aria-describedby="x_crimeDate_help">
<?= $Page->crimeDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->crimeDate->getErrorMessage() ?></div>
<?php if (!$Page->crimeDate->ReadOnly && !$Page->crimeDate->Disabled && !isset($Page->crimeDate->EditAttrs["readonly"]) && !isset($Page->crimeDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fappealadd", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fappealadd", "x_crimeDate", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fappealadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fappealadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("appeal");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
