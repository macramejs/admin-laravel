import { useSaveQueue, SaveQueue } from '@macramejs/macrame-vue3';

const saveQueue: SaveQueue = useSaveQueue();

const saveKeyboardShortcut = () => {
    document.addEventListener('keydown', (e) => {
        let modifier = window.navigator.platform.match('Mac')
            ? e.metaKey
            : e.ctrlKey;

        if (modifier && e.key === 's') {
            e.preventDefault();
            saveQueue.save();
        }
    });
};

export { saveQueue, saveKeyboardShortcut };
