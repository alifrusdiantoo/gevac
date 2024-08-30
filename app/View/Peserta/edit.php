<main class="row container-fluid m-0 p-0">
    <?php require __DIR__ . "/../Component/sidebar.php" ?>

    <section class="col bg-light">
        <div class="container-fluid p-0">
            <?php if (!empty($model['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $model['error']; ?>
                </div>
            <?php } ?>
            <div class="card p-4">
                <p class="fs-6 mb-4"><b>Edit Peserta</b></p>
                <form action="/peserta/edit/<?= $model["peserta"]["id"] ?>" method="post">
                    <input type="text" class="form-control bg-light d-none" id="id" name="id" value="<?= $model["peserta"]["id"] ?>" readonly>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" inputmode="numeric" pattern="[0-9]{16}" class="form-control" id="nik" name="nik" placeholder="320xxxxxx" maxlength="16" value="<?= $_POST["nik"] ?? $model["peserta"]["nik"] ?>" required />
                        </div>
                        <div class="col">
                            <label for="tglLahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tglLahir" name="tglLahir" max="getMaxDate()" value="<?= $_POST["tglLahir"] ?? $model["peserta"]["tglLahir"] ?>" required />
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="John Doe" value="<?= $_POST["nama"] ?? $model["peserta"]["nama"] ?>" required />
                    </div>

                    <div class="mb-3">
                        <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" aria-label="Select jenis kelamin" name="jenisKelamin">
                            <option value="L" <?= ($_POST["jenisKelamin"] ?? $model["peserta"]["jenisKelamin"]) == "L" ? "selected" : "" ?>>Laki-Laki</option>
                            <option value="P" <?= ($_POST["jenisKelamin"] ?? $model["peserta"]["jenisKelamin"]) == "P" ? "selected" : "" ?>>Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="dusun" class="form-label">Dusun</label>
                        <select class="form-select" aria-label="Select dusun" name="dusun">
                            <?php foreach ($model["dusun"] as $dusun) : ?>
                                <option value="<?= $dusun["id"] ?>" <?= ($_POST["dusun"] ?? $model["peserta"]["idDusun"]) == $dusun["id"] ? "selected" : "" ?>><?= $dusun["nama"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="rt" class="form-label">RT</label>
                            <input type="text" class="form-control" id="rt" name="rt" placeholder="00x" minlength="3" maxlength="3" value="<?= $_POST["rt"] ?? $model["peserta"]["rt"] ?>" required />
                            <div class="form-text">Gunakan format tiga digit (1 menjadi 001)</div>
                        </div>
                        <div class="col">
                            <label for="rw" class="form-label">RW</label>
                            <input type="text" class="form-control" id="rw" name="rw" placeholder="00x" minlength="3" maxlength="3" value="<?= $_POST["rw"] ?? $model["peserta"]["rw"] ?>" required />
                            <div class="form-text">Gunakan format tiga digit (1 menjadi 001)</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="kontak" class="form-label">Kontak</label>
                        <input type="tel" pattern="[0-9]{11-13}" class="form-control" id="kontak" name="kontak" placeholder="08xxxxxxxxxx" minlength="11" maxlength="13" value="<?= $_POST["kontak"] ?? $model["peserta"]["kontak"] ?>" required />
                    </div>

                    <div class="mb-5">
                        <label for="dosis" class="form-label">Dosis Vaksin</label>
                        <select class="form-select" aria-label="Select dosis" name="dosis">
                            <option value="1" <?= ($_POST["dosis"] ?? $model["peserta"]["dosis"]) == "1" ? "selected" : "" ?>>1</option>
                            <option value="2" <?= ($_POST["dosis"] ?? $model["peserta"]["dosis"]) == "2" ? "selected" : "" ?>>2</option>
                            <option value="3" <?= ($_POST["dosis"] ?? $model["peserta"]["dosis"]) == "3" ? "selected" : "" ?>>3</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    <button type="reset" class="btn btn-sm btn-danger">Reset</button>
                </form>
            </div>
        </div>
    </section>
</main>