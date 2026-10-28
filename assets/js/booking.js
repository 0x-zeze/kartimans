/**
 * The Kartimans Haircut - Modern Minimalist Booking Interaction Engine
 */

document.addEventListener('DOMContentLoaded', function () {
  const bookingForm = document.getElementById('bookingForm');
  if (!bookingForm) return;

  const dateInput = document.getElementById('bookingDate');
  const slotsContainer = document.getElementById('slotsContainer');
  const slotsLoading = document.getElementById('slotsLoading');
  const slotsEmpty = document.getElementById('slotsEmpty');
  const slotsPlaceholder = document.getElementById('slotsPlaceholder');
  const submitBtn = document.getElementById('submitBookingBtn');
  const submitText = document.getElementById('submitText');
  const submitSpinner = document.getElementById('submitSpinner');
  const bookingAlert = document.getElementById('bookingAlert');

  // Summary elements
  const sumBarber = document.getElementById('sumBarber');
  const sumDate = document.getElementById('sumDate');
  const sumTime = document.getElementById('sumTime');

  let selectedBarberId = null;
  let selectedBarberName = '-';
  let selectedDate = dateInput ? dateInput.value : '';
  let selectedSlot = null;

  // 1. Initial State Check
  const checkedBarber = document.querySelector('input[name="barber_id"]:checked');
  if (checkedBarber) {
    selectedBarberId = checkedBarber.value;
    selectedBarberName = checkedBarber.getAttribute('data-name') || '-';
    if (sumBarber) sumBarber.textContent = selectedBarberName;
  }

  // 2. Barber Change Listener
  document.querySelectorAll('input[name="barber_id"]').forEach((radio) => {
    radio.addEventListener('change', function () {
      selectedBarberId = this.value;
      selectedBarberName = this.getAttribute('data-name') || '-';
      if (sumBarber) sumBarber.textContent = selectedBarberName;
      selectedSlot = null;
      if (sumTime) sumTime.textContent = '-';
      updateSubmitButtonState();
      loadAvailableSlots();
    });
  });

  // 3. Date Change Listener
  if (dateInput) {
    dateInput.addEventListener('change', function () {
      selectedDate = this.value;
      if (sumDate) {
        sumDate.textContent = selectedDate ? formatDateIndo(selectedDate) : '-';
      }
      selectedSlot = null;
      if (sumTime) sumTime.textContent = '-';
      updateSubmitButtonState();
      loadAvailableSlots();
    });
  }

  // 4. Load Slots from Server via AJAX
  function loadAvailableSlots() {
    if (!selectedBarberId || !selectedDate) {
      if (slotsPlaceholder) slotsPlaceholder.style.display = 'block';
      if (slotsContainer) slotsContainer.innerHTML = '';
      if (slotsEmpty) slotsEmpty.style.display = 'none';
      return;
    }

    if (slotsPlaceholder) slotsPlaceholder.style.display = 'none';
    if (slotsEmpty) slotsEmpty.style.display = 'none';
    if (slotsLoading) slotsLoading.style.display = 'block';
    if (slotsContainer) slotsContainer.innerHTML = '';

    const url = window.KARTIMANS_CONFIG.baseUrl + 'booking/slots?barber_id=' + encodeURIComponent(selectedBarberId) + '&tanggal=' + encodeURIComponent(selectedDate);

    fetch(url, {
      headers: {
        'Accept': 'application/json'
      }
    })
      .then((res) => res.json())
      .then((res) => {
        if (slotsLoading) slotsLoading.style.display = 'none';

        if (res.status === 'success' && res.data && res.data.slots && res.data.slots.length > 0) {
          renderSlots(res.data.slots);
        } else {
          if (slotsEmpty) {
            slotsEmpty.style.display = 'block';
            slotsEmpty.textContent = res.message || 'Tidak ada jadwal tersedia untuk tanggal ini.';
          }
        }
      })
      .catch((err) => {
        if (slotsLoading) slotsLoading.style.display = 'none';
        if (slotsEmpty) {
          slotsEmpty.style.display = 'block';
          slotsEmpty.textContent = 'Gagal memuat jadwal. Silakan periksa koneksi internet Anda.';
        }
      });
  }

  // 5. Render Slots into UI
  function renderSlots(slots) {
    if (!slotsContainer) return;
    slotsContainer.innerHTML = '';

    let availableCount = 0;

    slots.forEach((item) => {
      const col = document.createElement('div');
      col.className = 'slot-item' + (!item.available ? ' disabled' : '');

      const radio = document.createElement('input');
      radio.type = 'radio';
      radio.name = 'jam';
      radio.id = 'slot_' + item.time.replace(':', '_');
      radio.value = item.time;
      if (!item.available) {
        radio.disabled = true;
      } else {
        availableCount++;
      }

      const label = document.createElement('label');
      label.htmlFor = radio.id;
      label.className = 'slot-item-label';
      label.title = item.reason;
      label.innerHTML = `<span>${item.time}</span>`;

      if (item.available) {
        radio.addEventListener('change', function () {
          selectedSlot = this.value;
          if (sumTime) sumTime.textContent = selectedSlot + ' WIB';
          updateSubmitButtonState();
        });
      }

      col.appendChild(radio);
      col.appendChild(label);
      slotsContainer.appendChild(col);
    });

    if (availableCount === 0 && slotsEmpty) {
      slotsEmpty.style.display = 'block';
      slotsEmpty.textContent = 'Semua slot pada tanggal ini sudah penuh terisi.';
    }
  }

  function formatDateIndo(dateStr) {
    if (!dateStr) return '-';
    const parts = dateStr.split('-');
    if (parts.length !== 3) return dateStr;
    const months = [
      'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    const day = parseInt(parts[2], 10);
    const month = months[parseInt(parts[1], 10) - 1];
    const year = parts[0];
    return `${day} ${month} ${year}`;
  }

  function updateSubmitButtonState() {
    const custName = document.getElementById('custName') ? document.getElementById('custName').value.trim() : '';
    const custWa = document.getElementById('custWa') ? document.getElementById('custWa').value.trim() : '';

    const isValid = selectedBarberId && selectedDate && selectedSlot && custName.length >= 3 && custWa.length >= 8;

    if (submitBtn) {
      submitBtn.disabled = !isValid;
    }
  }

  ['custName', 'custWa'].forEach((id) => {
    const el = document.getElementById(id);
    if (el) {
      el.addEventListener('input', updateSubmitButtonState);
    }
  });

  bookingForm.addEventListener('submit', function (e) {
    e.preventDefault();

    if (!selectedBarberId || !selectedDate || !selectedSlot) {
      showAlert('danger', 'Silakan lengkapi pemilihan barber, tanggal, dan slot jam.');
      return;
    }

    const custName = document.getElementById('custName').value.trim();
    const custWa = document.getElementById('custWa').value.trim();
    const notes = document.getElementById('custNotes') ? document.getElementById('custNotes').value.trim() : '';

    if (custName.length < 3) {
      showAlert('danger', 'Nama lengkap minimal 3 karakter.');
      return;
    }
    if (custWa.length < 8) {
      showAlert('danger', 'Nomor WhatsApp minimal 8 digit.');
      return;
    }

    setLoadingState(true);
    hideAlert();

    const formData = new FormData();
    formData.append('barber_id', selectedBarberId);
    formData.append('tanggal', selectedDate);
    formData.append('jam', selectedSlot);
    formData.append('nama', custName);
    formData.append('no_wa', custWa);
    formData.append('catatan', notes);

    if (window.KARTIMANS_CONFIG.csrfName && window.KARTIMANS_CONFIG.csrfHash) {
      formData.append(window.KARTIMANS_CONFIG.csrfName, window.KARTIMANS_CONFIG.csrfHash);
    }

    fetch(window.KARTIMANS_CONFIG.baseUrl + 'booking/submit', {
      method: 'POST',
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      }
    })
      .then((res) => res.json())
      .then((res) => {
        if (res.status === 'success') {
          window.location.href = res.redirect_url;
        } else {
          setLoadingState(false);
          showAlert('danger', res.message || 'Terjadi kesalahan saat memproses booking.');
          loadAvailableSlots();
        }
      })
      .catch((err) => {
        setLoadingState(false);
        showAlert('danger', 'Gagal menghubungi server. Silakan coba beberapa saat lagi.');
      });
  });

  function setLoadingState(loading) {
    if (!submitBtn) return;
    submitBtn.disabled = loading;
    if (loading) {
      if (submitText) submitText.textContent = 'Memproses Booking...';
      if (submitSpinner) submitSpinner.style.display = 'inline-block';
    } else {
      if (submitText) submitText.textContent = 'Konfirmasi Booking';
      if (submitSpinner) submitSpinner.style.display = 'none';
      updateSubmitButtonState();
    }
  }

  function showAlert(type, message) {
    if (!bookingAlert) return;
    bookingAlert.className = 'alert alert-' + type + ' py-2 px-3 mb-3';
    bookingAlert.textContent = message;
    bookingAlert.style.display = 'block';
    bookingAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }

  function hideAlert() {
    if (!bookingAlert) return;
    bookingAlert.style.display = 'none';
  }

  if (selectedBarberId && selectedDate) {
    loadAvailableSlots();
  }
});


