<form id="chat-form" method="POST" action="<?= base_url('chat/add') ?>" style="display: flex; gap: 8px; align-items: flex-end;">
  <textarea name="comment" id="commentBox" placeholder="Type your message..." rows="1" required
    style="resize: none; overflow: hidden; min-height: 38px; max-height: 150px; width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; font-size: 1em;"></textarea>
  <button type="submit" style="padding: 8px 16px;">Send</button>
</form>
